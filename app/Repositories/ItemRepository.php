<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ItemRepository
{
    public function all(): array
    {
        return Cache::rememberForever('catalog.items', function () {
            $path = base_path('resources/data/equipment.json');

            if (!is_file($path)) {
                return [];
            }

            $json = file_get_contents($path);
            if ($json === false || trim($json) === '') {
                return [];
            }

            $data = json_decode($json, true);
            if (!is_array($data)) {
                return [];
            }

            $items = [];

            foreach ($data as $group => $rows) {
                if (!is_array($rows) || !array_is_list($rows)) {
                    continue;
                }

                foreach ($rows as $row) {
                    $normalized = $this->normalizeItem($group, $row);
                    if ($normalized) {
                        $items[] = $normalized;
                    }
                }
            }

            usort($items, fn ($a, $b) => strcmp($a['name'], $b['name']));

            return $items;
        });
    }

    public function categories(): array
    {
        $set = [];
        foreach ($this->all() as $item) {
            $set[$item['category']] = true;
        }

        $out = array_keys($set);
        sort($out);

        return $out;
    }

    public function search(?string $query = null, ?string $category = null): array
    {
        $query = Str::lower(trim((string) $query));
        $category = $category ? Str::lower(trim($category)) : null;

        return array_values(array_filter($this->all(), function ($item) use ($query, $category) {
            if ($category && Str::lower($item['category']) !== $category) {
                return false;
            }

            if ($query !== '' && !str_contains(Str::lower($item['name']), $query)) {
                return false;
            }

            return true;
        }));
    }

    public function byCategory(string $category): array
    {
        return $this->search(null, $category);
    }

    public function findById(string $id): ?array
    {
        foreach ($this->all() as $item) {
            if ($item['id'] === $id) {
                return $item;
            }
        }

        return null;
    }

    private function normalizeItem(string $group, array $row): ?array
    {
        if ($group === 'armor' && isset($row['armor_name'])) {
            return [
                'id' => Str::slug($row['armor_name']),
                'name' => $row['armor_name'],
                'category' => 'armor',
                'type' => $row['armor_type'] ?? 'Armor',
                'cost_number' => $row['cost'][0]['number'] ?? 0,
                'cost_currency' => $row['cost'][0]['currency'] ?? 'gp',
                'weight' => $row['armor_weight'] ?? null,
                'description' => $row['armor_description'] ?? '',
                'image' => null,
                'armor' => [
                    'ac' => $row['armor_ac'][0]['ac'] ?? null,
                    'dex_mod' => $row['armor_ac'][0]['dexMod'] ?? false,
                    'max_dex_mod' => $row['armor_ac'][0]['maxDexMod'] ?? -1,
                    'strength_requirement' => $row['armor_strengthRequirement'] ?? 0,
                    'stealth_disadvantage' => $row['armor_stealthDisadvantage'] ?? false,
                ],
                'raw' => $row,
            ];
        }

        if ($group === 'weapon' && isset($row['weapon_name'])) {
            return [
                'id' => Str::slug($row['weapon_name']),
                'name' => $row['weapon_name'],
                'category' => 'weapons',
                'type' => $row['weapon_type'] ?? 'Weapon',
                'cost_number' => $row['cost'][0]['number'] ?? 0,
                'cost_currency' => $row['cost'][0]['currency'] ?? 'gp',
                'weight' => $row['weapon_weight'] ?? null,
                'description' => $this->joinDescriptions($row['weapon_descriptions'] ?? []),
                'image' => null,
                'weapon' => [
                    'damage_dice' => $row['damage'][0]['dice'] ?? null,
                    'damage_type' => $row['damage'][0]['type'] ?? null,
                    'properties' => $row['weapon_properties'] ?? '',
                ],
                'raw' => $row,
            ];
        }

        if ($group === 'adventuringGear' && isset($row['gear_name'])) {
            return [
                'id' => Str::slug($row['gear_name']),
                'name' => $row['gear_name'],
                'category' => 'gear',
                'type' => $row['gear_type'] ?? 'Gear',
                'cost_number' => $row['cost'][0]['number'] ?? 0,
                'cost_currency' => $row['cost'][0]['currency'] ?? 'gp',
                'weight' => $row['gear_weight'] ?? null,
                'description' => $row['gear_description'] ?? '',
                'image' => null,
                'raw' => $row,
            ];
        }

        if ($group === 'tools' && isset($row['tool_name'])) {
            return [
                'id' => Str::slug($row['tool_name']),
                'name' => $row['tool_name'],
                'category' => 'gear',
                'type' => $row['tool_type'] ?? 'Tool',
                'cost_number' => $row['cost'][0]['number'] ?? 0,
                'cost_currency' => $row['cost'][0]['currency'] ?? 'gp',
                'weight' => $row['tool_weight'] ?? null,
                'description' => $row['tool_description'] ?? '',
                'image' => null,
                'raw' => $row,
            ];
        }

        if ($group === 'mountsAndAnimals' && isset($row['mount_name'])) {
            return [
                'id' => Str::slug($row['mount_name']),
                'name' => $row['mount_name'],
                'category' => 'other',
                'type' => 'Mount/Animal',
                'cost_number' => $row['cost'][0]['number'] ?? 0,
                'cost_currency' => $row['cost'][0]['currency'] ?? 'gp',
                'weight' => null,
                'description' => $row['mount_description'] ?? '',
                'image' => null,
                'raw' => $row,
            ];
        }

        if ($group === 'tackHarnessVehicles' && isset($row['vehicle_name'])) {
            return [
                'id' => Str::slug($row['vehicle_name']),
                'name' => $row['vehicle_name'],
                'category' => 'other',
                'type' => $row['vehicle_type'] ?? 'Vehicle',
                'cost_number' => $row['cost'][0]['number'] ?? 0,
                'cost_currency' => $row['cost'][0]['currency'] ?? 'gp',
                'weight' => $row['vehicle_weight'] ?? null,
                'description' => $row['vehicle_description'] ?? '',
                'image' => null,
                'raw' => $row,
            ];
        }

        return null;
    }

    private function joinDescriptions(array $descriptions): string
    {
        $parts = [];

        foreach ($descriptions as $desc) {
            $title = trim((string)($desc['title'] ?? ''));
            $body = trim((string)($desc['description'] ?? ''));

            if ($title && $body) {
                $parts[] = "{$title}: {$body}";
            } elseif ($body) {
                $parts[] = $body;
            }
        }

        return implode("\n\n", $parts);
    }
}
