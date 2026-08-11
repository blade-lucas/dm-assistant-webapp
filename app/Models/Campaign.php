<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Character;

class Campaign extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'setting_theme',
        'tone',
        'world_description',
        'starting_level',
        'max_level',
        'campaign_summary',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sessionNotes()
    {
        return $this->hasMany(SessionNote::class);
    }

    public function characters()
    {
        return $this->hasMany(Character::class);
    }
}
