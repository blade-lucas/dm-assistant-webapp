<?php

namespace App\Services;

class DungeonGeneratorService
{
    public function generate(array $params): array
    {
        $roomCount = (int) $params['room_count'];

        $rooms = [];
        for ($i = 1; $i <= $roomCount; $i++) {
            $rooms[] = [
                'name' => "Room {$i}",
                'type' => $this->mockRoomType($i, $roomCount, !empty($params['boss_room'])),
                'summary' => $this->mockRoomSummary($params['theme'], $params['difficulty']),
            ];
        }

        return [
            'name' => $params['name'] ?: 'Untitled Dungeon',
            'theme' => $params['theme'],
            'size' => $params['size'],
            'difficulty' => $params['difficulty'],
            'room_count' => $roomCount,
            'encounter_density' => $params['encounter_density'],
            'puzzle_frequency' => $params['puzzle_frequency'],
            'trap_frequency' => $params['trap_frequency'],
            'boss_room' => !empty($params['boss_room']),
            'treasure_density' => $params['treasure_density'],
            'tone' => $params['tone'],
            'generate_description' => !empty($params['generate_description']),
            'generate_npcs' => !empty($params['generate_npcs']),
            'seed' => $params['seed'] ?: null,

            // mock output for now
            'map_placeholder' => true,
            'description' => !empty($params['generate_description'])
                ? "A {$params['tone']} {$params['theme']} dungeon built for a {$params['difficulty']} adventure."
                : null,
            'npcs' => !empty($params['generate_npcs'])
                ? [
                    ['name' => 'Warden Elric', 'role' => 'Guardian'],
                    ['name' => 'Mira Ashvale', 'role' => 'Explorer'],
                ]
                : [],
            'rooms' => $rooms,
        ];
    }

    private function mockRoomType(int $index, int $total, bool $bossRoom): string
    {
        if ($bossRoom && $index === $total) {
            return 'Boss Chamber';
        }

        $types = [
            'Entrance',
            'Hallway',
            'Barracks',
            'Shrine',
            'Puzzle Room',
            'Treasure Room',
            'Trap Room',
            'Guard Post',
            'Library',
            'Storage',
        ];

        return $types[array_rand($types)];
    }

    private function mockRoomSummary(string $theme, string $difficulty): string
    {
        return "A {$difficulty} {$theme}-themed chamber with environmental storytelling and encounter potential.";
    }
}
