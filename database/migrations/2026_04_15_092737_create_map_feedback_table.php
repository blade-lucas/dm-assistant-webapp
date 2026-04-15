<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('map_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('map_id')->nullable()->constrained()->nullOnDelete();

            $table->string('feedback_type', 30)->default('general');
            $table->string('dungeon_name')->nullable();
            $table->string('theme', 60)->nullable();
            $table->string('tone', 60)->nullable();

            $table->text('comments')->nullable();

            $table->unsignedTinyInteger('map_rating')->nullable();
            $table->unsignedTinyInteger('layout_rating')->nullable();
            $table->unsignedTinyInteger('overall_rating')->nullable();

            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('map_feedback');
    }
};
