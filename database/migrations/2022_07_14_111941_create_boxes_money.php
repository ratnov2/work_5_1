<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoxesMoney extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boxes_money', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('boxes_money_categories');
            $table->string('name');
            $table->string('image');
            $table->decimal('price', 64, 2);
            $table->decimal('profit_precent', 64, 2)->default(10);
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
        Schema::dropIfExists('boxes_money');
    }
}
