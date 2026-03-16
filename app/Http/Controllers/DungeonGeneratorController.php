<?php

namespace App\Http\Controllers;

use App\Services\DungeonGeneratorService;
use Illuminate\Http\Request;

class DungeonGeneratorController extends Controller
{
    public function index()
    {
        return view('dungeons.generate', [
            'result' => null,
        ]);
    }

    public function generate(Request $request, DungeonGeneratorService $generator)
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:120'],
            'theme' => ['required', 'string', 'max:60'],
            'size' => ['required', 'string', 'in:small,medium,large,huge'],
            'difficulty' => ['required', 'string', 'in:easy,medium,hard,deadly'],
            'room_count' => ['required', 'integer', 'min:3', 'max:50'],
            'encounter_density' => ['required', 'string', 'in:low,medium,high'],
            'puzzle_frequency' => ['required', 'string', 'in:none,low,medium,high'],
            'trap_frequency' => ['required', 'string', 'in:none,low,medium,high'],
            'boss_room' => ['nullable', 'boolean'],
            'treasure_density' => ['required', 'string', 'in:low,medium,high'],
            'tone' => ['required', 'string', 'max:60'],
            'generate_description' => ['nullable', 'boolean'],
            'generate_npcs' => ['nullable', 'boolean'],
            'seed' => ['nullable', 'string', 'max:60'],
        ]);

        $result = $generator->generate($validated);

        return view('dungeons.generate', [
            'result' => $result,
        ])->withInput();
    }
}
