<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsWithdrawTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_withdraw', function (Blueprint $table) {
            $table->id();
            $table->decimal('min_sum_payments_all_time', 64, 2)->default(15.00);
            $table->decimal('min_sum_payments_day', 64, 2)->default(15.00);
            $table->decimal('min_sum_payments_week', 64, 2)->default(15.00);
            $table->decimal('min_sum_payments_month', 64, 2)->default(15.00);
            $table->boolean('is_win_back_mode')->default(1);
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
        Schema::dropIfExists('settings_withdraw');
    }
}
