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
        $theme = $request->input('theme');
        $roomsRaw = $request->input('rooms');
        $guidance = $request->input('guidance', 2.5);

        // Normalize 1–50 → 0.0–1.0
        $rooms = $roomsRaw / 50;

        $response = Http::post('http://127.0.0.1:8001/sample', [
            'theme' => $theme,
            'rooms' => $rooms,
            'guidance' => floatval($guidance),
            'steps' => 20,
            'eta' => 0.0
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Map generation service unavailable'], 500);
        }

        return response()->json([
            'image' => $response->json()['image']
        ]);
    }
}
