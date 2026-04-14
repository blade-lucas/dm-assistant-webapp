<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;

class CurrencyRepository
{
    public function all(): array
    {
        return Cache::rememberForever('catalog.currency', function () {
            $path = base_path('resources/data/currency.json');

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

            return $data['startingWealth'] ?? [];
        });
    }

    public function forClass(?string $className): ?array
    {
        if (!$className) {
            return null;
        }

        foreach ($this->all() as $row) {
            if (($row['character_class'] ?? null) === $className) {
                return $row;
            }
        }

        return null;
    }

    public function rollStartingGold(?string $className): int
    {
        $row = $this->forClass($className);
        if (!$row) {
            return 0;
        }

        $roll = (string)($row['roll'] ?? '0-d4');
        $multiplier = (int)($row['multiplier'] ?? 1);

        // format like "5-d4"
        [$count, $die] = array_pad(explode('-', $roll), 2, null);
        $count = (int)$count;
        $die = (int)str_replace('d', '', strtolower((string)$die));

        if ($count <= 0 || $die <= 0) {
            return 0;
        }

        $sum = 0;
        for ($i = 0; $i < $count; $i++) {
            $sum += random_int(1, $die);
        }

        return $sum * $multiplier;
    }
}
