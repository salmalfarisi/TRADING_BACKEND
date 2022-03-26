<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TransactionController extends Controller
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
        if($request->amount <= 0.00000001)
		{
			return $this->sendError('Decline', ["trx_id" => "isi value lebih dari 0.00000001"]);
		}
		
		
		sleep(30);
		$validator = Validator::make($request->all(), [
            'trx_id' => 'required|unique:transaction,trx_id',
			'amount' => 'required|numeric',
			'user_id' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
		
		$checkuser = DB::table('users')->where('id', $request->user_id)->first();
		if($checkuser == '')
		{
            return $this->sendError('Validation error', ['user_id' => "user_id tidak ditemukan"]);
		}
		
		$getbalance = DB::table('balance')->where('user_id', $request->user_id)->first();
		
		if((float) $request->amount > (float) $getbalance->amount_available)
		{
            return $this->sendError('Validation error', ['amount' => "total transaksi lebih besar dari tabungan anda saat ini"]);
		}
		else
		{	
			$total = (float) $getbalance->amount_available - (float) $request->amount;
		}
		
		$now = Carbon::now();
		DB::table('transaction')->insert([
			'trx_id' => $request->trx_id,
			'amount' => $request->amount,
			'user_id' => $request->user_id,
			'created_at' => $now,
			'updated_at' => $now,
		]);
		
		DB::table('balance')->where('user_id', $request->user_id)->update(['amount_available' => $total, 'updated_at' => $now]);
		
		$array = [
					'trx_id' => $request->trx_id,
					'amount' => $request->amount,
				];
		
		return $this->sendResponse(true, $array, 'Transaction success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
