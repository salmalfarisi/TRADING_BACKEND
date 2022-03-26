<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BalanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayamount = [0.00674223, 1.00000000, 0.00000001, 21.00000000,];
		
		DB::table('balance')->truncate();
		
		for($i= 1; $i <=4; $i++)
		{
			DB::table('balance')->insert([
				'user_id' => $i,
				'amount_available' => $arrayamount[$i-1],
				'created_at' => '2022-03-07 09:00:00',
				'updated_at' => '2022-03-25 11:15:00',
			]);	
		}
    }
}
