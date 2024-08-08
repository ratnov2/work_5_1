<?php

use App\Containers\Trade\Data\Types\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_player_id')->constrained('item_player');
            $table->string('market_hash_name', 255);
            $table->decimal('price', 64, 2)->unsigned();
            $table->string('custom_id', 255);
            $table->decimal('paid', 64, 2)->nullable();
            $table->enum('status', array_column(Status::cases(), 'value'));
            $table->text('result');
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
        Schema::dropIfExists('trades');
    }
}
