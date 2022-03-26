<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coin__prices', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
			$table->string('name')->nullable();
			$table->string('ticker')->nullable();
			$table->integer('coin_id')->unsigned();
			$table->string('code')->nullable();
			$table->string('exchange')->nullable();
			$table->boolean('invalid')->default(false);
			$table->string("record_time")->nullable();
			$table->decimal("usd", 45, 15)->nullable();
			$table->decimal("idr", 45, 15)->nullable();
			$table->decimal("hnst", 45, 15)->nullable();
			$table->decimal("eth", 45, 15)->nullable();
			$table->decimal("btc", 45, 15)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coin__prices');
    }
}
