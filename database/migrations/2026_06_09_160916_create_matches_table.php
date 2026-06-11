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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_team_id')
                ->constrained('world_cup_teams')
                ->restrictOnDelete();
            $table->foreignId('away_team_id')
                ->constrained('world_cup_teams')
                ->restrictOnDelete();
            $table->dateTime('match_time');
            $table->enum('stage', [
                'group',
                'round_of_32',
                'round_of_16',
                'quarter_final',
                'semi_final',
                'third_place',
                'final'
            ]);
            $table->string('group', 1)->nullable(); // hanya diisi jika stage = group
            $table->string('venue')->nullable();
            $table->unsignedTinyInteger('home_score')->nullable();
            $table->unsignedTinyInteger('away_score')->nullable();
            $table->enum('status', ['scheduled', 'live', 'finished'])->default('scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
