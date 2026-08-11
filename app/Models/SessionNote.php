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
        'unresolved_hooks',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
