<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsSocials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_socials', function (Blueprint $table) {
            $table->id();
            $table->integer('VKONTAKTE_CLIENT_ID')->nullable();
            $table->text('VKONTAKTE_CLIENT_SECRET')->nullable();
            $table->text('TELEGRAM_BOT_NAME')->nullable();
            $table->text('TELEGRAM_TOKEN')->nullable();
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
        Schema::dropIfExists('settings_socials');
    }
}
