<?php

namespace App\Services\DungeonGenerator;

class Dungeon
{
    public function __construct(
        public int $width,
        public int $height,
        public array $tiles,
        public array $rooms,
        public array $corridors,
        public array $metadata = []
    ) {}

    public function toArray(): array
    {
        return [
            'width' => $this->width,
            'height' => $this->height,
            'tiles' => $this->tiles,
            'rooms' => array_map(fn ($room) => $room->toArray(), $this->rooms),
            'corridors' => array_map(fn ($corridor) => $corridor->toArray(), $this->corridors),
            'doors' => $this->metadata['doors'] ?? [],
            'metadata' => $this->metadata,
        ];
    }

    public function toAscii(): string
    {
        $output = '';

        foreach ($this->tiles as $row) {
            foreach ($row as $tile) {
                $output .= match ($tile['type']) {
                    'wall' => '#',
                    'floor' => '.',
                    'corridor' => '+',
                    'entrance' => 'S',
                    'exit' => 'E',
                    'door' => 'D',
                    default => '?',
                };
            }

            $output .= "\n";
        }

        return $output;
    }
}
