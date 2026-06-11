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
        Schema::table('predictions', function (Blueprint $table) {
            $table->index(['user_id', 'points']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('location_id');
            $table->index('supported_team_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('predictions', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'points']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['location_id']);
            $table->dropIndex(['supported_team_id']);
        });
    }
};
