<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsBoxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_box', function (Blueprint $table) {
            $table->id();
            $table->boolean('box_promocode')->default(true);
            $table->boolean('box_timer')->default(true);
            $table->decimal('box_timer_max_item_price', 64, 2)->default(1.00);
            $table->decimal('box_timer_min_sum_payments_time_day', 64, 2)->default(0.00);
            $table->decimal('box_promocode_max_item_price', 64, 2)->default(1.00);
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
        Schema::dropIfExists('settings_box');
    }
}
