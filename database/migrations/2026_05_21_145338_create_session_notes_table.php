<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('session_notes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('campaign_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');
            $table->unsignedInteger('session_number')->nullable();
            $table->date('session_date')->nullable();

            $table->text('summary')->nullable();
            $table->text('important_events')->nullable();
            $table->text('unresolved_hooks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_notes');
    }
};
