<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MonsterRepository
{

    public function all(): array
    {
        return \Illuminate\Support\Facades\Cache::rememberForever('catalog.monsters', function () {

            $fullPath = base_path('resources/data/monsters.json');

            if (!is_file($fullPath)) {
                return [];
            }

            $json = file_get_contents($fullPath);
            if ($json === false || trim($json) === '') {
                return [];
            }

            $data = json_decode($json, true);

            // expected: top-level array
            if (is_array($data) && array_is_list($data)) {
                return $data;
            }

            // if wrapped: { monsters: [...] }
            if (is_array($data)) {
                foreach (['monsters', 'data', 'results', 'items'] as $key) {
                    if (isset($data[$key]) && is_array($data[$key])) {
                        return $data[$key];
                    }
                }
            }

            return [];
        });
    }

    public function types(): array
    {
        return Cache::rememberForever('catalog.monsters.types', function () {
            $types = [];
            foreach ($this->all() as $m) {
                $t = trim((string)($m['m_type'] ?? ''));
                if ($t !== '') $types[$t] = true;
            }
            $types = array_keys($types);
            sort($types);
            return $types;
        });
    }

    public function slugFor(array $monster): string
    {
        return Str::slug((string)($monster['m_name'] ?? ''));
    }

    public function findBySlug(string $slug): ?array
    {
        $slug = trim($slug);
        if ($slug === '') return null;

        foreach ($this->all() as $m) {
            if ($this->slugFor($m) === $slug) return $m;
        }
        return null;
    }

    public function search(string $query = '', ?string $type = null, ?float $maxCr = null, int $limit = 300): array
    {
        $query = Str::lower(trim($query));
        $type = $type ? Str::lower(trim($type)) : null;

        $out = [];

        foreach ($this->all() as $m) {
            $name = Str::lower($m['m_name'] ?? '');

            if ($query !== '' && !str_contains($name, $query)) {
                continue;
            }

            if ($type) {
                $monsterType = Str::lower($m['m_type'] ?? '');
                if ($monsterType !== $type) continue;
            }

            if ($maxCr !== null) {
                $cr = $this->toCr($m['m_cr'] ?? null);
                if ($cr === null || $cr > $maxCr) continue;
            }

            $out[] = $m;

            if (count($out) >= $limit) break;
        }

        // Sort results alphabetically for predictable demo
        usort($out, fn($a, $b) => strcmp((string)($a['m_name'] ?? ''), (string)($b['m_name'] ?? '')));

        return $out;
    }

    private function toCr($value): ?float
    {
        if ($value === null) return null;
        $s = trim((string)$value);
        if ($s === '') return null;

        if (str_contains($s, '/')) {
            [$a, $b] = array_map('trim', explode('/', $s, 2));
            if (is_numeric($a) && is_numeric($b) && (float)$b != 0.0) {
                return (float)$a / (float)$b;
            }
        }

        return is_numeric($s) ? (float)$s : null;
    }
}
