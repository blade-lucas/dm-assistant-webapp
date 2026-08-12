<?php

namespace App\Http\Controllers;

use App\Models\Dungeon;
use Illuminate\Http\Request;
use App\Services\DungeonGenerator\DungeonConfig;
use App\Services\DungeonGenerator\DungeonGenerator;

class DungeonController extends Controller
{
    public function index()
    {
        $dungeons = Dungeon::latest()->get();

        return view('dungeon.index', [
            'dungeons' => $dungeons,
        ]);
    }

    public function create()
    {
        return view('dungeon.generate');
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'campaign_id' => ['nullable', 'integer', 'exists:campaigns,id'],
            'width' => ['nullable', 'integer', 'min:30', 'max:200'],
            'height' => ['nullable', 'integer', 'min:30', 'max:200'],
            'room_count' => ['nullable', 'integer', 'min:3', 'max:50'],
            'min_room_size' => ['nullable', 'integer', 'min:3', 'max:30'],
            'max_room_size' => ['nullable', 'integer', 'min:4', 'max:40'],
            'seed' => ['nullable', 'integer', 'min:1'],
            'type' => ['nullable', 'string', 'max:50'],
            'theme' => ['nullable', 'string', 'max:255'],
        ]);

        $campaignId = null;

        if (!empty($validated['campaign_id'])) {
            $campaign = \App\Models\Campaign::where('user_id', auth()->id())
                ->findOrFail($validated['campaign_id']);

            $campaignId = $campaign->id;
        }

        $generator = new DungeonGenerator();

        $dungeon = $generator->generate(
            new DungeonConfig(
                width: $validated['width'] ?? 80,
                height: $validated['height'] ?? 50,
                roomCount: $validated['room_count'] ?? 12,
                minRoomSize: $validated['min_room_size'] ?? 5,
                maxRoomSize: $validated['max_room_size'] ?? 12,
                seed: $validated['seed'] ?? null,
                type: $validated['type'] ?? 'crypt',
                theme: $validated['theme'] ?? 'ancient undead crypt',
            )
        );

        return view('dungeon.canvas-viewer', [
            'dungeon' => $dungeon->toArray(),
            'savedDungeon' => null,
            'campaignId' => $campaignId,
        ]);
    }

    public function show(Dungeon $dungeon)
    {
        return view('dungeon.canvas-viewer', [
            'dungeon' => $dungeon->dungeon_data,
            'savedDungeon' => $dungeon,
            'campaignId' => $dungeon->campaign_id,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'campaign_id' => ['nullable', 'integer', 'exists:campaigns,id'],
        ]);

        $campaignId = null;

        if (!empty($validated['campaign_id'])) {
            $campaign = \App\Models\Campaign::where('user_id', auth()->id())
                ->findOrFail($validated['campaign_id']);

            $campaignId = $campaign->id;
        }

        // Keep campaign_id out of dungeon_data itself.
        $data = $request->except('campaign_id');

        $dungeon = Dungeon::create([
            'user_id' => auth()->id(),
            'campaign_id' => $campaignId,
            'name' => $data['name'] ?? ('Dungeon ' . ($data['metadata']['seed'] ?? time())),
            'type' => $data['metadata']['type'] ?? 'unknown',
            'theme' => $data['metadata']['theme'] ?? null,
            'seed' => $data['metadata']['seed'] ?? 0,
            'dungeon_data' => $data,
        ]);

        return response()->json([
            'success' => true,
            'id' => $dungeon->id,
            'campaign_id' => $dungeon->campaign_id,
            'redirect_url' => $dungeon->campaign_id
                ? route('campaigns.dungeons.index', $dungeon->campaign_id)
                : route('dungeon-new.show', $dungeon),
        ]);
    }
}
