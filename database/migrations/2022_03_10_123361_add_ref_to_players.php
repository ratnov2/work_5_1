<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRefToPlayers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->foreignId('ref_level_id')->after('id')->constrained('ref_levels');
            $table->decimal('ref_balance', 64, 2)->unsigned()->default(0.00)->after('id');
            $table->foreignId('referrer_id')->after('id')->nullable()->constrained('players');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropConstrainedForeignId('ref_level_id');
            $table->dropConstrainedForeignId('referrer_id');
        });
    }
}
