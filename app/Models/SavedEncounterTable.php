<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedEncounterTable extends Model
{
    protected $fillable = [
        'user_id',
        'campaign_id',
        'name',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
