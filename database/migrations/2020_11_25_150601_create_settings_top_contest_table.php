<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTopContestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_top_contest', function (Blueprint $table) {
            $table->id();
            $table->integer('every_hours');
            $table->decimal('first_place_sum', 64, 2)->default(0.00);
            $table->decimal('second_place_sum', 64, 2)->default(0.00);
            $table->decimal('third_place_sum', 64, 2)->default(0.00);
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
        Schema::dropIfExists('settings_top_contest');
    }
}
