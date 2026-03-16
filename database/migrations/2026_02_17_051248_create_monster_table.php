<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('monsters', function (Blueprint $table) {
            $table->id();

            // Your primary identifier for lookups (slug)
            $table->string('slug')->unique();

            // Core indexed/searchable fields
            $table->string('name')->index();
            $table->string('type')->nullable()->index();      // m_type
            $table->string('size')->nullable()->index();      // m_size
            $table->string('alignment')->nullable()->index(); // m_alignment

            // Numbers for filtering/encounter building
            $table->decimal('cr', 6, 2)->nullable()->index(); // m_cr (0.25, 1, 10, etc.)
            $table->integer('xp')->nullable()->index();       // m_exp
            $table->integer('ac')->nullable();                // m_ac
            $table->integer('hp')->nullable();                // m_defaultHP

            // Optional quick filters
            $table->boolean('legendary')->default(false)->index(); // m_legendary
            $table->boolean('has_spell_slots')->default(false)->index(); // m_spellSlots

            // Full original payload
            $table->jsonb('data');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monsters');
    }
};
