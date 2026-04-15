<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapFeedback extends Model
{
    protected $table = 'map_feedback';

    protected $fillable = [
        'user_id',
        'map_id',
        'feedback_type',
        'dungeon_name',
        'theme',
        'tone',
        'comments',
        'map_rating',
        'layout_rating',
        'overall_rating',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function map()
    {
        return $this->belongsTo(Map::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
