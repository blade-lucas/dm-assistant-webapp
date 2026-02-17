<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();

            $table->string('name')->default('New Character');
            $table->unsignedSmallInteger('level')->default(1);

            $table->string('race')->nullable();
            $table->string('class')->nullable();
            $table->string('alignment')->nullable();

            // One of: player | party_npc | generic_npc
            $table->string('role')->default('player');

            // Core stats & editor data
            $table->jsonb('abilities')->nullable();     // { str: 10, dex: 10, con: 10, int: 10, wis: 10, cha: 10 }
            $table->jsonb('skills')->nullable();        // { proficient: {acrobatics:true,...}, bonuses:{acrobatics:2,...} }
            $table->jsonb('features')->nullable();      // appearance, talents, etc.

            // Derived quick stats (you can refine later when equipment/armor exists)
            $table->unsignedSmallInteger('ac')->nullable();
            $table->smallInteger('initiative')->nullable();
            $table->unsignedSmallInteger('speed')->nullable();

            // Future tabs (equipment/spells/notes/etc.)
            $table->jsonb('data')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
