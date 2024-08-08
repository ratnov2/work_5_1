<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsPaymentSystems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_payment_systems', function (Blueprint $table) {
            $table->id();
            $table->integer('ENOT_MERCHANT_ID')->nullable();
            $table->text('ENOT_SECRET_WORD')->nullable();
            $table->text('ENOT_EXTRA_SECRET_WORD')->nullable();
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
        Schema::dropIfExists('settings_payment_systems');
    }
}
