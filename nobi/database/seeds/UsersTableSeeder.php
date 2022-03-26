<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('balance')->truncate();
        DB::table('transaction')->truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('users')->truncate();
		
		for($i = 1; $i <=4; $i++)
		{
			$name = 'user'.$i;
			$email = $name.'@email.com';
			$password = Hash::make($name);
			DB::table('users')->insert([
				'name' => $name,
				'email' => $email,
				'password' => $password,
				'created_at' => '2022-03-07 09:00:00',
				'updated_at' => '2022-03-25 11:15:00',
			]);
		}
    }
}
