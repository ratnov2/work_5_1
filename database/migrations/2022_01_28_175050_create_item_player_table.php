<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemPlayerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_player', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('player_id')->constrained('players');
            $table->string('market_hash_name', 255);
            $table->decimal('price', 64, 2)->unsigned();
            $table->string('uniqid', 36);
            $table->morphs('dropable');
            $table->enum('status', ['ready', 'selled', 'jackpoted', 'upgraded', 'minesed', 'traded', 'trade_proccessed']);
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
        Schema::dropIfExists('item_player');
    }
}
