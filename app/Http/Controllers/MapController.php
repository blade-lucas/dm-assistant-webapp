<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MapController extends Controller
{
    public function generate(Request $request)
    {
        $response = Http::post('http://127.0.0.1:8001/sample', [
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