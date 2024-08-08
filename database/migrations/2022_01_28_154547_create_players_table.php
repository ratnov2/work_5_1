<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('trade_link', 255)->nullable()->unique();
            $table->string('ref_code', 255)->nullable()->unique();
            $table->decimal('balance', 64, 2)->unsigned()->default(0.00);
            $table->string('image', 255)->nullable();
            $table->bigInteger('steam_id')->unsigned()->unique();
            $table->boolean('ban')->default(false);
            $table->boolean('withdraw')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
    }
}
