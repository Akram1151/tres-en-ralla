<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('player_x');
            $table->string('player_o');
            $table->json('board');
            $table->string('turn', 1); // 'X' o 'O'
            $table->string('winner', 1)->nullable(); // 'X', 'O' o null
            $table->boolean('is_draw')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
