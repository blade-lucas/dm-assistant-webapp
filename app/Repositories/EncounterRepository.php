<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;

class EncounterRepository
{
    public function all(): array
    {
        return Cache::rememberForever('catalog.encounters', function () {
            $fullPath = base_path('resources/data/encounters.json');
            if (!is_file($fullPath)) return [];

            $json = file_get_contents($fullPath);
            if ($json === false || trim($json) === '') return [];

            $data = json_decode($json, true);
            if (!is_array($data)) return [];

            // Your file shape: { "encounter": [ ... ] }
            if (isset($data['encounter']) && is_array($data['encounter'])) {
                return $data['encounter'];
            }

            // fallback: if it's already a list
            if (array_is_list($data)) return $data;

            return [];
        });
    }

    public function locationTypes(): array
    {
        $set = [];
        foreach ($this->all() as $e) {
            $v = trim((string)($e['encounterLocationType'] ?? ''));
            if ($v !== '') $set[$v] = true;
        }
        $out = array_keys($set);
        sort($out);
        return $out;
    }

    public function locationSubtypes(?string $type = null): array
    {
        $set = [];
        foreach ($this->all() as $e) {
            $t = trim((string)($e['encounterLocationType'] ?? ''));
            if ($type && $t !== $type) continue;

            $v = trim((string)($e['encounterLocationSubtype'] ?? ''));
            if ($v !== '') $set[$v] = true;
        }
        $out = array_keys($set);
        sort($out);
        return $out;
    }

    public function filter(?string $type, ?string $subtype, array $encounterTypes): array
    {
        $encounterTypes = array_values(array_filter(array_map('trim', $encounterTypes)));

        $rows = array_values(array_filter($this->all(), function ($e) use ($type, $subtype, $encounterTypes) {
            if ($type && (($e['encounterLocationType'] ?? null) !== $type)) return false;
            if ($subtype && (($e['encounterLocationSubtype'] ?? null) !== $subtype)) return false;

            // encounters.json stores one type as string: "Friendly" etc.
            if (!empty($encounterTypes)) {
                $t = (string)($e['encounterTypes'] ?? '');
                if (!in_array($t, $encounterTypes, true)) return false;
            }

            return true;
        }));

        // Sort by min roll (nice table order)
        usort($rows, fn($a, $b) => ((int)($a['encounterMinRoll'] ?? 0)) <=> ((int)($b['encounterMinRoll'] ?? 0)));

        return $rows;
    }

    public function pickByRoll(array $filteredRows, int $roll): ?array
    {
        foreach ($filteredRows as $e) {
            $min = (int)($e['encounterMinRoll'] ?? 0);
            $max = (int)($e['encounterMaxRoll'] ?? 0);
            if ($roll >= $min && $roll <= $max) return $e;
        }
        return null;
    }
}
