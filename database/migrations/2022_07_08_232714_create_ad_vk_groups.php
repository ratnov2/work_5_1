<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdVkGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_vk_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->string('vk_id');
            $table->string('vk_short_name');
            $table->text('access_token');
            $table->text('callback_server_secret_key')->nullable();
            $table->string('callback_server_id')->nullable();
            $table->boolean('confirmation')->default(0);
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
        Schema::dropIfExists('ad_vk_groups');
    }
}
