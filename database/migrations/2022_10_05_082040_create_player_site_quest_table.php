<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerSiteQuestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_site_quest', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('players');
            $table->foreignId('site_quest_id')->constrained('site_quests');
            $table->decimal('reward_price', 64, 2)->default(0);
            $table->text('wait_work_comment')->nullable();
            $table->text('wait_done_comment')->nullable();
            $table->json('wait_work_answer')->nullable();
            $table->json('wait_done_answer')->nullable();
            $table->enum('status', ['in_start', 'wait_work', 'in_working', 'wait_done', 'done'])->default('in_working');
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
        Schema::dropIfExists('player_site_quest');
    }
}
