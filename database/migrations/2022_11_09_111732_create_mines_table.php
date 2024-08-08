<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mines_games', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_id')->nullable(); $table->foreign('player_id')->references('id')->on('players');
            $table->json('cell_results')->nullable();
            $table->integer('count_mines');
            $table->decimal('win_amount', 64, 2)->nullable();
            $table->decimal('balance', 64, 2)->nullable();
            $table->string('market_hash_name', 255)->nullable();
            $table->enum('status', ['in_game', 'end']);
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
        Schema::dropIfExists('mines_games');
    }
}
