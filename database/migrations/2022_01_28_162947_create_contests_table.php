<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contests', function (Blueprint $table) {
            $table->id();
            $table->integer('position');
            $table->foreignId('win_player_id')->constrained('players');
            $table->string('market_hash_name', 255);
            $table->enum('status', ['wait', 'active', 'finish']);
            $table->enum('type', ['default', 'sponsor'])->default('default');
            $table->timestamp('reserved_at');
            $table->timestamp('end_at');
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('contests');
    }
}
