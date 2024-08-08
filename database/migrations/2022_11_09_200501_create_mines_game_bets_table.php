<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinesGameBetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mines_game_bets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mines_game_id')->nullable(); $table->foreign('mines_game_id')->references('id')->on('mines_games');
            $table->unsignedBigInteger('item_player_id')->nullable(); $table->foreign('item_player_id')->references('id')->on('item_player');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mines_game_bets');
    }
}
