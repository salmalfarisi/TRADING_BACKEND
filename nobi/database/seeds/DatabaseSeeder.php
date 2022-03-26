<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		$checkdata = true;
		for($i = 1; $i <=4; $i++)
		{
			$finddata = DB::table('users')->where('id', $i)->limit(1)->count();
			if($finddata == 0)
			{
				//$checkdata = false;
				//dd('Harap untuk melakukan registrasi data dengan user_id = '.$i);
				/* 
				$name = 'user'.$i;
				$email = $name.'@email.com';
				$password = Hash::make($name);
				DB::table('users')->insert([
					'id' => $i,
					'name' => $name,
					'email' => $email,
					'password' => $password,
					'created_at' => '2022-03-07 09:00:00',
					'updated_at' => '2022-03-25 11:15:00',
				]); 
				*/
			}
		}
		
		if($checkdata == true)
		{
			$this->call(BalanceTableSeeder::class);
			$this->call(TransactionTableSeeder::class);
			$this->call(QuoteTableSeeder::class);
			//$this->call(Coin_PriceSeeder::class);			
		}
    }
}
