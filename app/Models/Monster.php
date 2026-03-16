<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monster extends Model
{
    protected $fillable = [
        'slug','name','type','size','alignment',
        'cr','xp','ac','hp','legendary','has_spell_slots','data',
    ];

    protected $casts = [
        'data' => 'array',
        'legendary' => 'boolean',
        'has_spell_slots' => 'boolean',
        'cr' => 'decimal:2',
    ];
}
