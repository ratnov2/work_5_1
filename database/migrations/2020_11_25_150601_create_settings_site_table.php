<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsSiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_site', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->string('favicon', 255)->nullable();
            $table->string('logo', 255)->nullable();
            $table->string('youtube_link', 255)->nullable();
            $table->string('telegram_link', 255)->nullable();
            $table->string('vk_link', 255)->nullable();
            $table->text('footer')->nullable();
            $table->text('keywords')->nullable();
            $table->text('yandex_metrika')->nullable();
            $table->text('yandex_metrika_informer')->nullable();
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
        Schema::dropIfExists('settings_site');
    }
}
