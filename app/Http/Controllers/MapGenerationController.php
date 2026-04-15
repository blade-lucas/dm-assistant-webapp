<?php

namespace App\Http\Controllers;

use App\Models\Map;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\StoryGeneratorService;

class MapGenerationController extends Controller
{
    public function index()
    {
        return view('maps.index');
    }

    public function generate(Request $request, StoryGeneratorService $storyService)
    {
        $validated = $request->validate([
            'theme' => ['required', 'string', 'max:60'],
            'room_count' => ['required', 'integer', 'min:3', 'max:50'],
            'guidance' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'tone' => ['nullable', 'string', 'max:60'],
        ]);

        set_time_limit(180);
        ini_set('max_execution_time', '180');

        $theme = $validated['theme'];
        $roomCount = (int) $validated['room_count'];
        $guidance = (float) ($validated['guidance'] ?? 2.5);
        $rooms = $roomCount / 50;

        $response = Http::connectTimeout(15)
            ->timeout(120)
            ->post(config('services.mapgen.url') . '/sample', [
                'theme' => $theme,
                'rooms' => $rooms,
                'guidance' => $guidance,
                'steps' => 10,
                'eta' => 0.0,
            ]);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Map generation service unavailable',
                'details' => $response->json() ?? $response->body(),
            ], 500);
        }

        $imageBase64 = $response->json()['image'] ?? null;

        if (!$imageBase64) {
            return response()->json([
                'error' => 'Map service returned no image.',
            ], 500);
        }

        $storyText = null;

        try {
            $binary = base64_decode($imageBase64, true);

            if ($binary !== false) {
                $tmpPath = storage_path('app/tmp/' . Str::uuid() . '.png');

                if (!is_dir(dirname($tmpPath))) {
                    mkdir(dirname($tmpPath), 0775, true);
                }

                file_put_contents($tmpPath, $binary);

                $storyResponse = $storyService->generateFromImage(
                    absolutePath: $tmpPath,
                    filename: basename($tmpPath),
                    mimeType: 'image/png',
                    tone: $validated['tone'] ?? null,
                );

                $storyText = $storyResponse['story_text'] ?? null;

                @unlink($tmpPath);
            }
        } catch (\Throwable $e) {
            \Log::error('Preview story generation failed', [
                'error' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'image' => $imageBase64,
            'story_text' => $storyText,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:120'],
            'theme' => ['nullable', 'string', 'max:60'],
            'size' => ['nullable', 'string', 'max:30'],
            'difficulty' => ['nullable', 'string', 'max:30'],
            'room_count' => ['nullable', 'integer', 'min:3', 'max:50'],
            'encounter_density' => ['nullable', 'string', 'max:30'],
            'treasure_density' => ['nullable', 'string', 'max:30'],
            'tone' => ['nullable', 'string', 'max:60'],
            'guidance_strength' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'image_base64' => ['required', 'string'],
        ]);

        $imageData = $validated['image_base64'];

        // Strip data URL prefix if present
        if (str_starts_with($imageData, 'data:image')) {
            [$meta, $imageData] = explode(',', $imageData, 2);
            $mime = str_contains($meta, 'jpeg') ? 'jpeg' : (str_contains($meta, 'webp') ? 'webp' : 'png');
        } else {
            $mime = 'png';
        }

        $binary = base64_decode($imageData, true);

        if ($binary === false) {
            return back()->withErrors(['image_base64' => 'Generated image data is invalid.']);
        }

        $filename = 'maps/' . Str::uuid() . '.' . $mime;
        Storage::disk('public')->put($filename, $binary);

        $map = Map::create([
            'user_id' => $request->user()->id,
            'name' => $validated['name'] ?: 'Untitled Map',
            'theme' => $validated['theme'] ?? null,
            'size' => $validated['size'] ?? null,
            'difficulty' => $validated['difficulty'] ?? null,
            'room_count' => $validated['room_count'] ?? null,
            'encounter_density' => $validated['encounter_density'] ?? null,
            'treasure_density' => $validated['treasure_density'] ?? null,
            'tone' => $validated['tone'] ?? null,
            'guidance_strength' => $validated['guidance_strength'] ?? null,
            'image_path' => $filename,
            'meta' => [],
        ]);

        // 🔥 Generate story immediately after saving map
        try {
            $storyService = app(StoryGeneratorService::class);

            $absolutePath = storage_path('app/public/' . $filename);

            $storyResponse = $storyService->generateFromImage(
                absolutePath: $absolutePath,
                filename: basename($filename),
                mimeType: 'image/' . $mime,
                tone: $validated['tone'] ?? null,
            );

            \App\Models\MapStory::create([
                'map_id' => $map->id,
                'story_text' => $storyResponse['story_text'] ?? 'No story generated.',
                'tone' => $validated['tone'] ?? null,
                'meta' => $storyResponse,
            ]);

        } catch (\Throwable $e) {
            \Log::error('Story generation failed', [
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()
            ->route('saves.show', ['type' => 'maps', 'id' => $map->id])
            ->with('status', 'Map saved.');
    }
}
