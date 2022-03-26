<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use file;

class CoinPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {	
		$validator = Validator::make($request->all(), [
            'file.*' => 'required|mimes:csv|max:100000',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
		
		$filename = $request->file('file')->getClientOriginalName();
		
		$totaldata = DB::table('files')->where('name', $filename)->count();
		if($totaldata != 0)
		{
			return $this->sendError('Validation Error.', ["file" => ["File sudah tersimpan dalam database"]]);
		}
		
		DB::table('files')->insert(['name' => $filename]);
		
		$request->file->move(public_path('file'), $filename);
		
		$localfile = 'file/'.$filename;
		$handle = fopen(public_path($localfile), 'r');
		while (($line = fgetcsv($handle)) !== FALSE) 
		{
			$setinput = $line;
			if((string) $setinput[2] != (string) "ticker")
			{
				$checkdata = DB::table('coin__prices')->where('id', $setinput[0])->count();
				if($checkdata == 0)
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
		}
		fclose($handle);
		
		return $this->sendResponse(true, [], 'Upload berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Coin_Price  $coin_Price
     * @return \Illuminate\Http\Response
     */
    public function show(Coin_Price $coin_Price)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Coin_Price  $coin_Price
     * @return \Illuminate\Http\Response
     */
    public function edit(Coin_Price $coin_Price)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coin_Price  $coin_Price
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coin_Price $coin_Price)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coin_Price  $coin_Price
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coin_Price $coin_Price)
    {
        //
    }
	
	public function filteringminmax(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'week' => 'required|numeric|digits:2',
            'year' => 'required|numeric|digits:4',
			'ticker' => 'required|string',
			'currency' => 'required|string',
        ]);
		
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
		
		if(strtolower($request->currency) != 'usd' and strtolower($request->currency) != 'idr')
		{
			return $this->sendError('Validation Error.', ["currency" => ["Kurs yang anda pilih tidak tersedia dalam database"]]);
		}
		
		$currency = (string) strtolower($request->currency);
		
		$query = "SELECT * FROM `coin__prices` WHERE YEAR(created_at) = '".$request->year."' and ticker = '".$request->ticker."'";
		$results = DB::select($query);
		$array = [];
		foreach($results as $datas)
		{
			$getweeks = date("W", strtotime($datas->created_at));
			if($getweeks == $request->week)
			{
				array_push($array, $datas);
			}
		}
		
		$max = 0.0;
		$min = 1000000000000.0;
		foreach($array as $datas)
		{
			$getdata = $datas->$currency;
			if($getdata > $max)
			{
				$max = $getdata;
			}
			elseif($getdata < $min)
			{
				$min = $getdata;
			}
		}
		
		return $this->sendResponse(true, ['max' => $max, 'min' => $min], 'Ambil data terbesar dan terkecil');
	}
	
	public function history(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'ticker' => 'required|string',
			'currency' => 'required|string',
			'firstdate' => 'required|date_format:Y-m-d H:i:s',
			'lastdate' => 'required|date_format:Y-m-d H:i:s',
        ]);
		
		if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
		
		$currency = strtolower($request->currency);
		//SELECT * FROM `coin__prices` WHERE created_at between '2017-10-09 10:10:10' and '2017-10-10 10:10:10';
		
		$query = "SELECT * FROM `coin__prices` WHERE created_at between '".$request->firstdate."' and '".$request->lastdate."' ";
		$results = DB::select($query);
		
		return $this->sendResponse(true, $results, 'Histori berdasarkan filter');
	}
}
