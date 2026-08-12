<?php

namespace App\Http\Controllers;

use App\Models\Map;
use App\Models\MapStory;
use App\Services\StoryGeneratorService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

use App\Services\RagStoryService;

class MapGenerationController extends Controller
{
    public function index()
    {
        return view('maps.index');
    }

    public function generate(
        Request $request,
        StoryGeneratorService $storyService,
        RagStoryService $ragStoryService
    )
    {
        $validated = $request->validate([
            'theme' => ['required', 'string', 'max:60'],
            'room_count' => ['required', 'integer', 'min:3', 'max:50'],
            'tone' => ['nullable', 'string', 'max:60'],
            'difficulty' => ['nullable', 'string', 'max:30'],
        ]);

        set_time_limit(180);
        ini_set('max_execution_time', '180');

        $theme = $validated['theme'];
        $roomCount = (int) $validated['room_count'];
        $tone = $validated['tone'] ?? null;
        $difficulty = $validated['difficulty'] ?? 'medium';

        try {
            $mapResponse = Http::connectTimeout(15)
                ->timeout(120)
                ->acceptJson()
                ->post(rtrim(config('services.mapgen.url'), '/') . '/sample', [
                    'theme' => $theme,
                    'rooms' => $roomCount,
                    'w_theme' => 1.5,
                    'w_rooms' => 1.0,
                    'w_both' => 1.5,
                    'steps' => 50,
                ])
                ->throw();
        } catch (RequestException $e) {
            Log::error('Map generation request failed', [
                'message' => $e->getMessage(),
                'response' => optional($e->response)->body(),
            ]);

            return response()->json([
                'error' => 'Map generation service unavailable.',
            ], 500);
        }

        $imageBase64 = data_get($mapResponse->json(), 'image');

        if (!is_string($imageBase64) || trim($imageBase64) === '') {
            Log::error('Map generation returned no image', [
                'response' => $mapResponse->json(),
            ]);

            return response()->json([
                'error' => 'Map service returned no image.',
            ], 500);
        }

        $storyText = null;
        $storyMeta = null;

        try {
            $ragResponse = $ragStoryService->generate(
                theme: $theme,
                roomCount: $roomCount,
                tone: $tone,
                difficulty: $difficulty,
                campaignId: null,
                campaignNotes: null,
                userPrompt: null,
                partyLevel: 1,
                partySize: 4,
                rooms: [],
            );

            $storyText = $ragStoryService->storyToText($ragResponse);

            $storyMeta = [
                'source' => 'rag',
                'story' => $ragResponse['story'] ?? [],
                'retrieved_context' => $ragResponse['retrieved_context'] ?? [],
            ];
        } catch (Throwable $ragException) {
            Log::warning('RAG story generation failed; attempting image story fallback', [
                'message' => $ragException->getMessage(),
            ]);

            try {
                $tempPath = $this->writePreviewImageToTempFile($imageBase64);

                $storyResponse = $storyService->generateFromImage(
                    absolutePath: $tempPath,
                    filename: basename($tempPath),
                    mimeType: 'image/png',
                    tone: $tone,
                );

                $storyText = $storyResponse['story_text'] ?? null;

                $storyMeta = [
                    'source' => 'image_generator_fallback',
                    'response' => $storyResponse,
                ];
            } catch (Throwable $fallbackException) {
                Log::error('Both story generation services failed', [
                    'rag_error' => $ragException->getMessage(),
                    'fallback_error' => $fallbackException->getMessage(),
                ]);
            } finally {
                if (isset($tempPath) && is_string($tempPath) && is_file($tempPath)) {
                    @unlink($tempPath);
                }
            }
        }

        return response()->json([
            'image' => $imageBase64,
            'story_text' => $storyText,
            'story_meta' => $storyMeta,
        ]);
    }

    public function store(Request $request, StoryGeneratorService $storyService)
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
            'image_base64' => ['required', 'string'],

            // Optional preview-generated story so we do not have to regenerate on save
            'story_text' => ['nullable', 'string'],
            'story_meta' => ['nullable', 'string'],
        ]);

        [$binary, $mime] = $this->decodeImageBase64($validated['image_base64']);

        if ($binary === null) {
            return back()->withErrors([
                'image_base64' => 'Generated image data is invalid.',
            ]);
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
            'image_path' => $filename,
            'meta' => [],
        ]);

        $storyText = $validated['story_text'] ?? null;
        $storyMetaRaw = $validated['story_meta'] ?? null;
        $storyMeta = null;

        if (is_string($storyMetaRaw) && trim($storyMetaRaw) !== '') {
            $decodedMeta = json_decode($storyMetaRaw, true);
            if (is_array($decodedMeta)) {
                $storyMeta = $decodedMeta;
            }
        }

        try {
            // If preview already generated a story, reuse it.
            if ($storyText) {
                MapStory::create([
                    'map_id' => $map->id,
                    'story_text' => $storyText,
                    'tone' => $validated['tone'] ?? null,
                    'meta' => $storyMeta ?? [],
                ]);
            } else {
                // Fallback: generate story on save if preview story was missing
                $absolutePath = storage_path('app/public/' . $filename);

                $storyResponse = $storyService->generateFromImage(
                    absolutePath: $absolutePath,
                    filename: basename($filename),
                    mimeType: 'image/' . $mime,
                    tone: $validated['tone'] ?? null,
                );

                MapStory::create([
                    'map_id' => $map->id,
                    'story_text' => $storyResponse['story_text'] ?? 'No story generated.',
                    'tone' => $validated['tone'] ?? null,
                    'meta' => $storyResponse,
                ]);
            }
        } catch (Throwable $e) {
            Log::error('Story generation failed during save', [
                'message' => $e->getMessage(),
            ]);
        }

        return redirect()
            ->route('saves.show', ['type' => 'maps', 'id' => $map->id])
            ->with('status', 'Map saved.');
    }

    private function writePreviewImageToTempFile(string $imageBase64): string
    {
        $binary = base64_decode($imageBase64, true);

        if ($binary === false) {
            throw new \RuntimeException('Preview image base64 could not be decoded.');
        }

        $dir = storage_path('app/tmp');

        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $path = $dir . '/' . Str::uuid() . '.png';
        file_put_contents($path, $binary);

        return $path;
    }

    private function decodeImageBase64(string $imageData): array
    {
        $mime = 'png';

        if (str_starts_with($imageData, 'data:image')) {
            [$meta, $imageData] = explode(',', $imageData, 2);
            $mime = str_contains($meta, 'jpeg')
                ? 'jpeg'
                : (str_contains($meta, 'webp') ? 'webp' : 'png');
        }

        $binary = base64_decode($imageData, true);

        if ($binary === false) {
            return [null, $mime];
        }

        return [$binary, $mime];
    }

    public function destroy(Request $request, Map $map)
    {
        $user = $request->user();
        $isAdmin = (bool) ($user->is_admin ?? false);

        if (!$isAdmin && (int) $map->user_id !== (int) $user->id) {
            abort(403);
        }

        if ($map->image_path) {
            Storage::disk('public')->delete($map->image_path);
        }

        $map->delete();

        return redirect()
            ->route('saves.index', ['type' => 'maps'])
            ->with('status', 'Map deleted.');
    }
}
