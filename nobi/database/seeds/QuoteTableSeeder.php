<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class QuoteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('quote')->truncate();
		
		for($i = 1; $i <= 50; $i++)
		{
			$response = Http::get('https://api.chucknorris.io/jokes/random');
			$decode = $response->json();
			DB::table('quote')->insert([
				'url' => $decode["url"],
				'quote' => $decode["value"],
			]);
		}
    }
}
