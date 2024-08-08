<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('market_hash_name');
            $table->string('ru_market_hash_name')->nullable();
            $table->decimal('price', 64, 2);
            $table->decimal('price_market', 64, 2);
            $table->integer('quantity');
            $table->string('quality', 255)->nullable();
            $table->string('rarity', 255)->nullable();
            $table->string('class_instance', 255)->nullable();
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
        Schema::dropIfExists('items');
    }
}
