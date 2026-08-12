<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dungeon extends Model
{
    protected $fillable = [
        'user_id',
        'campaign_id',
        'name',
        'type',
        'theme',
        'seed',
        'dungeon_data',
    ];

    protected $casts = [
        'dungeon_data' => 'array',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
