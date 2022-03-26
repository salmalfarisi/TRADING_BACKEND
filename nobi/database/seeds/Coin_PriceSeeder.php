<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Coin_PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		/*
		 $table->unsignedBigInteger('id');
			$table->string('name')->nullable();
			$table->string('ticker')->nullable();
			$table->integer('coin_id')->unsigned();
			$table->string('exchange')->nullable();
			$table->boolean('invalid')->default(false);
			$table->string("record_time")->nullable();
			$table->decimal("usd", 45, 15)->nullable();
			$table->decimal("idr", 45, 15)->nullable();
			$table->decimal("hnst", 45, 15)->nullable();
			$table->decimal("eth", 45, 15)->nullable();
			$table->decimal("btc", 45, 15)->nullable();
            $table->timestamps();*/
		
		DB::table('coin__prices')->truncate();
		
		$handle = fopen(public_path('hasil.csv'), 'r');
		$header = true;
		while (($line = fgetcsv($handle)) !== FALSE) 
		{
			$setinput = $line;
			if((string) $setinput[2] != (string) "ticker")
			{
				DB::table('coin__prices')->insert([
					'id' => (int) $setinput[0],
					'name' => $setinput[1],
					'ticker' => $setinput[2],
					'coin_id' => (int) $setinput[3],
					'code' => $setinput[4],
					'exchange' => $setinput[5],
					'invalid' => $setinput[6],
					'record_time' => $setinput[7],
					'usd' => $setinput[8],
					'idr' => $setinput[9],
					'hnst' => $setinput[10],
					'eth' => $setinput[11],
					'btc' => $setinput[12],
					'created_at' => $setinput[13],
					'updated_at' => $setinput[14],
				]);				
			}
		}
		fclose($handle);
    }
}
