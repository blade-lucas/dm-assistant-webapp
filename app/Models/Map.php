<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'theme',
        'size',
        'difficulty',
        'room_count',
        'encounter_density',
        'treasure_density',
        'tone',
        'guidance_strength',
        'image_path',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
