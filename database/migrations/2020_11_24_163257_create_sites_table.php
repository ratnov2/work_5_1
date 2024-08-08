<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->integer('position')->unsigned();
            $table->foreignId('category_id')->constrained('site_categories')->onDelete('cascade');
            $table->string('price', 255);
            $table->string('image', 255);
            $table->string('promo', 255)->nullable();
            $table->string('link', 255);
            $table->boolean('show')->default(true);
            $table->boolean('new')->default(true);
            $table->boolean('hot')->default(false);
            $table->boolean('vpn')->default(false);
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
        Schema::dropIfExists('sites');
    }
}
