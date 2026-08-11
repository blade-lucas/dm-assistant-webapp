<?php

namespace App\Services\DungeonGenerator;

class Corridor
{
    public function __construct(
        public int $id,
        public int $fromRoomId,
        public int $toRoomId,
        public array $tiles = [],
        public string $type = 'standard',
        public array $metadata = [],
        public ?string $notes = null,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'from_room_id' => $this->fromRoomId,
            'to_room_id' => $this->toRoomId,
            'tiles' => $this->tiles,
            'type' => $this->type,
            'metadata' => $this->metadata,
            'notes' => $this->notes,
        ];
    }
}
