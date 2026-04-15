<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapStory extends Model
{
    protected $fillable = [
        'map_id',
        'story_text',
        'tone',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function map()
    {
        return $this->belongsTo(Map::class);
    }
}
