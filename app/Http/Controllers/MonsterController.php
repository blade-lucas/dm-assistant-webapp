<?php

namespace App\Http\Controllers;

use App\Repositories\MonsterRepository;
use Illuminate\Http\Request;

class MonsterController extends Controller
{
    public function index(Request $request, MonsterRepository $repo)
    {
        $q = (string)$request->query('q', '');
        $type = $request->query('type');
        $type = is_string($type) && trim($type) !== '' ? $type : null;

        $maxCrRaw = $request->query('max_cr');
        $maxCr = null;
        if (is_string($maxCrRaw) && trim($maxCrRaw) !== '' && is_numeric($maxCrRaw)) {
            $maxCr = (float)$maxCrRaw;
        }

        $results = $repo->search($q, $type, $maxCr);

        $selectedSlug = (string)$request->query('monster', '');
        $selected = $selectedSlug ? $repo->findBySlug($selectedSlug) : null;

        // If none selected, default to first result (nice UX)
        if (!$selected && !empty($results)) {
            $selected = $results[0];
            $selectedSlug = $repo->slugFor($selected);
        }

        return view('monsters.index', [
            'results' => $results,
            'selected' => $selected,
            'selectedSlug' => $selectedSlug,
            'types' => $repo->types(),
            'q' => $q,
            'type' => $type,
            'maxCr' => $maxCrRaw,
        ]);
    }
}
