<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentSystemDirectionCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_system_direction_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('direction_id'); $table->foreign('direction_id')->references('id')->on('payment_system_directions');
            $table->unsignedBigInteger('category_id'); $table->foreign('category_id')->references('id')->on('payment_system_categories');
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
        Schema::dropIfExists('payment_system_direction_category');
    }
}
