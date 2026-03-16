<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedEncounterTable extends Model
{
    protected $fillable = ['name', 'payload'];

    protected $casts = [
        'payload' => 'array',
    ];
}
