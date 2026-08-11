<?php

namespace App\Services\DungeonGenerator;

class Tile
{
    public function __construct(
        public int $x,
        public int $y,
        public string $type = 'wall',
        public ?int $roomId = null,
        public array $metadata = []
    ) {}
}
