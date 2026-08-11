<?php

namespace App\Services\DungeonGenerator;

class DungeonGenerator
{
    private DungeonConfig $config;
    private array $tiles = [];
    private array $rooms = [];
    private array $corridors = [];

    public function generate(DungeonConfig $config): Dungeon
    {
        $this->config = $config;

        mt_srand($config->seed);

        $this->initializeGrid();
        $this->placeRooms();
        $this->connectRooms();
        $this->assignSpecialRooms();
        $this->assignRoomGraphMetadata();

        return new Dungeon(
            width: $config->width,
            height: $config->height,
            tiles: $this->tiles,
            rooms: $this->rooms,
            corridors: $this->corridors,
            metadata: [
                'seed' => $config->seed,
                'type' => $config->type,
                'theme' => $config->theme,
            ]
        );
    }

    private function initializeGrid(): void
    {
        $this->tiles = [];

        for ($y = 0; $y < $this->config->height; $y++) {
            for ($x = 0; $x < $this->config->width; $x++) {
                $this->tiles[$y][$x] = [
                    'x' => $x,
                    'y' => $y,
                    'type' => 'wall',
                    'room_id' => null,
                    'corridor_id' => null,
                    'metadata' => [],
                ];
            }
        }
    }

    private function placeRooms(): void
    {
        $attempts = 0;
        $maxAttempts = $this->config->roomCount * 20;

        while (count($this->rooms) < $this->config->roomCount && $attempts < $maxAttempts) {
            $attempts++;

            $width = mt_rand($this->config->minRoomSize, $this->config->maxRoomSize);
            $height = mt_rand($this->config->minRoomSize, $this->config->maxRoomSize);

            $x = mt_rand(1, $this->config->width - $width - 2);
            $y = mt_rand(1, $this->config->height - $height - 2);

            $room = new Room(
                id: count($this->rooms) + 1,
                x: $x,
                y: $y,
                width: $width,
                height: $height
            );

            if ($this->roomOverlaps($room)) {
                continue;
            }

            $this->rooms[] = $room;
            $this->carveRoom($room);
        }
    }

    private function roomOverlaps(Room $room): bool
    {
        foreach ($this->rooms as $existingRoom) {
            if ($room->intersects($existingRoom, 2)) {
                return true;
            }
        }

        return false;
    }

    private function carveRoom(Room $room): void
    {
        for ($y = $room->y; $y < $room->y + $room->height; $y++) {
            for ($x = $room->x; $x < $room->x + $room->width; $x++) {
                $this->tiles[$y][$x]['type'] = 'floor';
                $this->tiles[$y][$x]['room_id'] = $room->id;
            }
        }
    }

    private function connectRooms(): void
    {
        if (count($this->rooms) < 2) {
            return;
        }

        $connected = [$this->rooms[0]->id];
        $unconnected = array_slice($this->rooms, 1);

        while (count($unconnected) > 0) {
            $fromRoom = $this->findClosestConnectedRoom($unconnected[0], $connected);
            $toRoom = array_shift($unconnected);

            $this->createConnection($fromRoom, $toRoom);
            $connected[] = $toRoom->id;
        }

        $this->addExtraConnections();
    }

    private function findClosestConnectedRoom(Room $targetRoom, array $connectedRoomIds): Room
    {
        $closestRoom = null;
        $closestDistance = PHP_INT_MAX;

        foreach ($this->rooms as $room) {
            if (!in_array($room->id, $connectedRoomIds, true)) {
                continue;
            }

            $distance = $this->roomDistance($room, $targetRoom);

            if ($distance < $closestDistance) {
                $closestDistance = $distance;
                $closestRoom = $room;
            }
        }

        return $closestRoom;
    }

    private function roomDistance(Room $a, Room $b): int
    {
        $centerA = $a->center();
        $centerB = $b->center();

        return abs($centerA['x'] - $centerB['x']) + abs($centerA['y'] - $centerB['y']);
    }

    private function createConnection(Room $fromRoom, Room $toRoom): void
    {
        if ($this->roomsAlreadyConnected($fromRoom, $toRoom)) {
            return;
        }

        $corridorId = count($this->corridors) + 1;

        $start = $fromRoom->center();
        $end = $toRoom->center();

        $corridorTiles = $this->carveCorridor(
            $start['x'],
            $start['y'],
            $end['x'],
            $end['y'],
            $corridorId
        );

        $this->corridors[] = new Corridor(
            id: $corridorId,
            fromRoomId: $fromRoom->id,
            toRoomId: $toRoom->id,
            tiles: $corridorTiles
        );

        $fromRoom->connectedRooms[] = $toRoom->id;
        $toRoom->connectedRooms[] = $fromRoom->id;
    }

    private function roomsAlreadyConnected(Room $a, Room $b): bool
    {
        return in_array($b->id, $a->connectedRooms, true)
            || in_array($a->id, $b->connectedRooms, true);
    }

    private function addExtraConnections(): void
    {
        $extraConnections = 0;

        foreach ($this->rooms as $room) {
            if ($extraConnections >= $this->config->maxExtraConnections) {
                return;
            }

            if (mt_rand(1, 100) > $this->config->extraConnectionChance) {
                continue;
            }

            $candidate = $this->findNearestUnconnectedRoom($room);

            if ($candidate === null) {
                continue;
            }

            $this->createConnection($room, $candidate);
            $extraConnections++;
        }
    }

    private function findNearestUnconnectedRoom(Room $room): ?Room
    {
        $closestRoom = null;
        $closestDistance = PHP_INT_MAX;

        foreach ($this->rooms as $candidate) {
            if ($candidate->id === $room->id) {
                continue;
            }

            if ($this->roomsAlreadyConnected($room, $candidate)) {
                continue;
            }

            $distance = $this->roomDistance($room, $candidate);

            if ($distance < $closestDistance) {
                $closestDistance = $distance;
                $closestRoom = $candidate;
            }
        }

        return $closestRoom;
    }

    private function carveCorridor(
        int $x1,
        int $y1,
        int $x2,
        int $y2,
        int $corridorId
    ): array {
        $corridorTiles = [];

        if (mt_rand(0, 1) === 0) {
            $this->carveHorizontalCorridor($x1, $x2, $y1, $corridorId, $corridorTiles);
            $this->carveVerticalCorridor($y1, $y2, $x2, $corridorId, $corridorTiles);
        } else {
            $this->carveVerticalCorridor($y1, $y2, $x1, $corridorId, $corridorTiles);
            $this->carveHorizontalCorridor($x1, $x2, $y2, $corridorId, $corridorTiles);
        }

        return $corridorTiles;
    }

    private function carveHorizontalCorridor(
        int $x1,
        int $x2,
        int $y,
        int $corridorId,
        array &$corridorTiles
    ): void {
        for ($x = min($x1, $x2); $x <= max($x1, $x2); $x++) {
            if ($this->tiles[$y][$x]['type'] === 'wall') {
                $this->tiles[$y][$x]['type'] = 'corridor';
                $this->tiles[$y][$x]['corridor_id'] = $corridorId;
            }

            $corridorTiles[] = ['x' => $x, 'y' => $y];
        }
    }

    private function carveVerticalCorridor(
        int $y1,
        int $y2,
        int $x,
        int $corridorId,
        array &$corridorTiles
    ): void {
        for ($y = min($y1, $y2); $y <= max($y1, $y2); $y++) {
            if ($this->tiles[$y][$x]['type'] === 'wall') {
                $this->tiles[$y][$x]['type'] = 'corridor';
                $this->tiles[$y][$x]['corridor_id'] = $corridorId;
            }

            $corridorTiles[] = ['x' => $x, 'y' => $y];
        }
    }

    private function assignSpecialRooms(): void
    {
        if (count($this->rooms) === 0) {
            return;
        }

        $roomTypes = $this->roomTypePools[$this->config->type] ?? ['room'];

        foreach ($this->rooms as $room) {
            $room->type = $roomTypes[array_rand($roomTypes)];
            $room->metadata = [
                'danger_level' => mt_rand(1, 5),
                'loot_quality' => mt_rand(1, 5),
            ];
        }

        $entranceRoom = $this->rooms[0];
        $entranceRoom->type = 'entrance';
        $entranceRoom->name = 'Dungeon Entrance';
        $entranceRoom->tags[] = 'starting_area';

        $this->assignRoomGraphMetadata();

        $bossRoom = $this->findFarthestRoomFrom($entranceRoom);
        $bossRoom->type = 'boss_room';
        $bossRoom->name = 'Boss Chamber';
        $bossRoom->tags[] = 'major_encounter';
        $bossRoom->metadata['danger_level'] = 5;

        $treasureRoom = $this->findBestTreasureRoom($entranceRoom, $bossRoom);

        if ($treasureRoom !== null) {
            $treasureRoom->type = 'treasure_room';
            $treasureRoom->name = 'Treasure Vault';
            $treasureRoom->tags[] = 'loot';
            $treasureRoom->tags[] = 'high_value';
            $treasureRoom->metadata['loot_quality'] = 5;
        }

        $entrance = $entranceRoom->center();
        $exit = $bossRoom->center();

        $this->tiles[$entrance['y']][$entrance['x']]['type'] = 'entrance';
        $this->tiles[$exit['y']][$exit['x']]['type'] = 'exit';
    }

    private function assignRoomGraphMetadata(): void
    {
        foreach ($this->rooms as $room) {
            $connectionCount = count($room->connectedRooms);

            $room->metadata['connection_count'] = $connectionCount;

            if ($connectionCount === 1) {
                $room->metadata['graph_role'] = 'dead_end';
                $room->tags[] = 'dead_end';
            } elseif ($connectionCount === 2) {
                $room->metadata['graph_role'] = 'path';
            } else {
                $room->metadata['graph_role'] = 'junction';
                $room->tags[] = 'junction';
            }
        }
    }

    private function findFarthestRoomFrom(Room $startRoom): Room
    {
        $farthestRoom = $startRoom;
        $farthestDistance = 0;

        foreach ($this->rooms as $room) {
            if ($room->id === $startRoom->id) {
                continue;
            }

            $distance = $this->roomDistance($startRoom, $room);

            if ($distance > $farthestDistance) {
                $farthestDistance = $distance;
                $farthestRoom = $room;
            }
        }

        return $farthestRoom;
    }

    private function findBestTreasureRoom(Room $entranceRoom, Room $bossRoom): ?Room
    {
        $candidates = array_filter($this->rooms, function (Room $room) use ($entranceRoom, $bossRoom) {
            return $room->id !== $entranceRoom->id
                && $room->id !== $bossRoom->id
                && ($room->metadata['graph_role'] ?? null) === 'dead_end';
        });

        if (count($candidates) === 0) {
            return null;
        }

        return $candidates[array_rand($candidates)];
    }

    private array $roomTypePools = [
        'crypt' => [
            'burial_chamber',
            'shrine',
            'ossuary',
            'ritual_room',
            'treasure_room',
            'hallway_room',
        ],

        'castle' => [
            'barracks',
            'storage_room',
            'throne_room',
            'hall',
            'armory',
            'kitchen',
        ],

        'sewer' => [
            'maintenance_room',
            'water_chamber',
            'junction',
            'storage',
        ],
    ];


}
