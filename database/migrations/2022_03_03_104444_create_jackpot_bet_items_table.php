<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJackpotBetItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jackpot_bet_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('market_hash_name', 255);
            $table->decimal('price', 64, 2)->unsigned();
            $table->foreignId('jackpot_bet_id')->constrained('jackpot_bets');
            $table->foreignId('item_player_id')->constrained('item_player');
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
        Schema::dropIfExists('jackpot_bet_items');
    }
}
