<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('session_notes', function (Blueprint $table) {
            $table->text('npcs_locations')
                ->nullable()
                ->after('important_events');

            $table->text('player_decisions')
                ->nullable()
                ->after('npcs_locations');

            $table->text('dm_notes')
                ->nullable()
                ->after('unresolved_hooks');
        });
    }

    public function down(): void
    {
        Schema::table('session_notes', function (Blueprint $table) {
            $table->dropColumn([
                'npcs_locations',
                'player_decisions',
                'dm_notes',
            ]);
        });
    }
};
