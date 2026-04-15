<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saved_encounter_tables', function (Blueprint $table) {
            $table->id();

            // User relationship (nullable in case of guest/system-generated content)
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->index();
            $table->string('name', 120);
            $table->jsonb('payload');
            $table->timestamps();
            $table->index(['user_id', 'created_at']);
            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_encounter_tables');
    }
};
