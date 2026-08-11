<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Campaign;

class Character extends Model
{
    protected $fillable = [
        'user_id','name','level','race','class','alignment','role',
        'abilities','skills','features',
        'ac','initiative','speed',
        'data',
        'campaign_id',
    ];

    protected $casts = [
        'abilities' => 'array',
        'skills'    => 'array',
        'features'  => 'array',
        'data'      => 'array',
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

