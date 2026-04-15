<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MapGenerationController extends Controller
{
    public function index()
    {
        return view('maps.index', [

        ]);
    }

    public function generate(Request $request)
    {
        set_time_limit(120);
        ini_set('max_execution_time', '120');

        $theme = $request->input('theme');
        $rooms = $request->input('rooms');
        $guidance = $request->input('guidance', 2.5);

        $response = Http::connectTimeout(15)
            ->timeout(120)
            ->post(config('services.mapgen.url') . '/sample', [
                'theme' => $theme,
                'rooms' => $rooms,
                'guidance' => $guidance,
                'steps' => 10,
                'eta' => 0.0,
            ]);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Map generation service unavailable'
            ], 500);
        }

        return response()->json([
            'image' => $response->json()['image'] ?? null
        ]);
    }
}
