<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('name')->nullable();
            $table->string('theme')->nullable();
            $table->string('size')->nullable();
            $table->string('difficulty')->nullable();
            $table->unsignedInteger('room_count')->nullable();
            $table->string('encounter_density')->nullable();
            $table->string('treasure_density')->nullable();
            $table->string('tone')->nullable();
            $table->decimal('guidance_strength', 3, 1)->nullable();

            $table->string('image_path');
            $table->json('meta')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maps');
    }
};
