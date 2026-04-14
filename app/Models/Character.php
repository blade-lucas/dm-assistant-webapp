<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $fillable = [
        'user_id','name','level','race','class','alignment','role',
        'abilities','skills','features',
        'ac','initiative','speed',
        'data',
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
}

