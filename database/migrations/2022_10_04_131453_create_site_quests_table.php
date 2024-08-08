<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteQuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_quests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites');
            $table->string('name', 255);
            $table->text('description');
            $table->decimal('reward_price', 64, 2)->default(5.00);
            $table->boolean('is_wait_work_answer_required')->default(false);
            $table->boolean('is_wait_done_answer_required')->default(true);
            $table->boolean('is_reusable')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamp('end_at')->nullable();
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
        Schema::dropIfExists('site_quests');
    }
}
