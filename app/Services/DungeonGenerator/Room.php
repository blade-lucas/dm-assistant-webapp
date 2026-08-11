<?php

namespace App\Services\DungeonGenerator;

class Room
{
    public function __construct(
        public int $id,
        public int $x,
        public int $y,
        public int $width,
        public int $height,
        public string $type = 'room',
        public ?string $name = null,
        public ?string $description = null,
        public array $tags = [],
        public array $connectedRooms = [],
        public array $metadata = [],
        public ?int $encounterId = null,
        public ?int $lootTableId = null,
        public ?string $notes = null,
    ) {}

    public function center(): array
    {
        return [
            'x' => intdiv($this->x + $this->x + $this->width, 2),
            'y' => intdiv($this->y + $this->y + $this->height, 2),
        ];
    }

    public function intersects(Room $other, int $padding = 1): bool
    {
        return !(
            $this->x + $this->width + $padding < $other->x ||
            $this->x > $other->x + $other->width + $padding ||
            $this->y + $this->height + $padding < $other->y ||
            $this->y > $other->y + $other->height + $padding
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->name,
            'description' => $this->description,
            'x' => $this->x,
            'y' => $this->y,
            'width' => $this->width,
            'height' => $this->height,
            'tags' => $this->tags,
            'connected_rooms' => $this->connectedRooms,
            'metadata' => $this->metadata,
            'encounter_id' => $this->encounterId,
            'loot_table_id' => $this->lootTableId,
            'notes' => $this->notes,
        ];
    }
}
