<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionNote extends Model
{
    protected $fillable = [
        'campaign_id',
        'title',
        'session_number',
        'session_date',
        'summary',
        'important_events',
        'npcs_locations',
        'player_decisions',
        'unresolved_hooks',
        'dm_notes',
    ];

    protected $casts = [
        'session_date' => 'date',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
