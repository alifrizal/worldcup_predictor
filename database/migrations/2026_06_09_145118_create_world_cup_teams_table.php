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
        Schema::create('world_cup_teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 3)->unique();   // ISO country code, e.g. BRA, FRA
            $table->string('flag_emoji', 10);       // e.g. 🇧🇷
            $table->string('flag_url')->nullable(); // opsional, untuk gambar flag
            $table->string('group', 1);             // A–L (48 tim = 12 grup)
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('world_cup_teams');
    }
};
