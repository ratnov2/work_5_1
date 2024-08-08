<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJackpotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jackpots', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('win_ticket')->nullable();
            $table->decimal('bank', 64, 2)->nullable();
            $table->decimal('win_item_price', 64, 2)->nullable();
            $table->decimal('win_balance', 64, 2)->nullable();
            $table->decimal('profit', 64, 2)->nullable();
            $table->enum('status', ['wait', 'wait_timeout', 'active', 'end'])->default('wait');
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
        Schema::dropIfExists('jackpots');
    }
}
