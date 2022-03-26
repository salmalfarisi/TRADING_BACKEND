<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TransactionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$arraytrx = ['a', 'B']; 
		$arrayamount = [0.01000000, 0.02000000];
		
		DB::table('transaction')->truncate();
		
		for($i = 1; $i <=2; $i++)
		{
			DB::table('transaction')->insert([
				'trx_id' => $arraytrx[$i-1],
				'user_id' => 1,
				'amount' => $arrayamount[$i-1],
				'created_at' => '2022-03-07 09:00:00',
				'updated_at' => '2022-03-25 11:15:00',
			]);	
		}
    }
}
