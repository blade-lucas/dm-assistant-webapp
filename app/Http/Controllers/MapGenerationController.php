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
        \Log::info('Incoming map request', [
            'all' => $request->all(),
            'theme' => $request->input('theme'),
            'rooms' => $request->input('rooms'),
            'guidance' => $request->input('guidance'),
            'content_type' => $request->header('Content-Type'),
        ]);

        $theme = $request->input('theme');
        $roomsRaw = $request->input('rooms');
        $guidance = $request->input('guidance', 2.5);

        $rooms = $roomsRaw / 50;

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
                'error' => 'Map generation service unavailable',
                'details' => $response->json() ?? $response->body(),
            ], 500);
        }

        return response()->json([
            'image' => $response->json()['image']
        ]);
    }
}
