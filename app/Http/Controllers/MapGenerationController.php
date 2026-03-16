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
        // Need to use uvicorn fastapi to work
        // I'll add you guys to the repo where I host the
        // model file.
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
