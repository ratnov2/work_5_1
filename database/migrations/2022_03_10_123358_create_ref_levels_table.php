<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_levels', function (Blueprint $table) {
            $table->id();
            $table->integer('sum_payments')->unsigned()->nullable();
            $table->integer('level')->unsigned()->nullable();
            $table->decimal('bonus_precent', 64, 2)->unsigned();
            $table->decimal('ref_bonus_precent', 64, 2)->unsigned();
            $table->string('type', 255);
            $table->string('name', 255)->nullable();
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
        Schema::dropIfExists('ref_levels');
    }
}
