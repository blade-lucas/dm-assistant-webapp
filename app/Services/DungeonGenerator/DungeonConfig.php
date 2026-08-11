<?php

namespace App\Services\DungeonGenerator;

class DungeonConfig
{
    public function __construct(
        public int $width = 80,
        public int $height = 50,
        public int $roomCount = 12,
        public int $minRoomSize = 5,
        public int $maxRoomSize = 12,
        public ?int $seed = null,
        public string $type = 'crypt',
        public string $theme = 'ancient crypt',
        public int $extraConnectionChance = 25,
        public int $maxExtraConnections = 3,
    ) {
        $this->seed ??= random_int(1, 999999);
    }
}
