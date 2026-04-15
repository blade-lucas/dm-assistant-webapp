<?php

namespace App\Http\Controllers;

use App\Models\MapFeedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'map_id' => ['nullable', 'integer', 'exists:maps,id'],
            'feedback_type' => ['required', 'in:general,bug,balance,feature'],
            'dungeon_name' => ['nullable', 'string', 'max:120'],
            'theme' => ['nullable', 'string', 'max:60'],
            'tone' => ['nullable', 'string', 'max:60'],
            'comments' => ['nullable', 'string', 'max:3000'],
            'map_rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'layout_rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'overall_rating' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        MapFeedback::create([
            'user_id' => $request->user()?->id,
            'map_id' => $validated['map_id'] ?? null,
            'feedback_type' => $validated['feedback_type'],
            'dungeon_name' => $validated['dungeon_name'] ?? null,
            'theme' => $validated['theme'] ?? null,
            'tone' => $validated['tone'] ?? null,
            'comments' => $validated['comments'] ?? null,
            'map_rating' => $validated['map_rating'] ?? null,
            'layout_rating' => $validated['layout_rating'] ?? null,
            'overall_rating' => $validated['overall_rating'] ?? null,
            'meta' => [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ],
        ]);

        return back()->with('status', 'Feedback submitted. Thanks!');
    }
}
