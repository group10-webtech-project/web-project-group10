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
        Schema::create('leaderboard', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->integer('total_games')->default(0);
            $table->integer('total_wins')->default(0);
            $table->float('avg_attempts')->default(0);
            $table->integer('current_streak')->default(0);
            $table->integer('best_streak')->default(0);
            $table->integer('points')->default(0);
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaderboard');
    }
};
