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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('setting_theme')->nullable();
            $table->string('tone')->nullable();
            $table->text('world_description')->nullable();

            $table->unsignedTinyInteger('starting_level')->nullable();
            $table->unsignedTinyInteger('max_level')->nullable();

            $table->text('campaign_summary')->nullable();

            $table->string('status')->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
