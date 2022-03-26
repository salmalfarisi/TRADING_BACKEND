<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Session;
use Hash;

class UsersController extends Controller
{
	public function register(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
			'name' => 'required|string',
			'password' => 'required|min:8',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
		
		$password = Hash::make($request->password);
		DB::table('users')->insert([
			'name' => $request->name,
			'email' => $request->email,
			'password' => $password,
		]);
		
		$id = DB::table('users')->orderBy('id', 'DESC')->limit(1)->value('id');
		$array = ['user_id' => $id];
		
		return $this->sendResponse(true, $array, 'Account has been successfully created');
	}
	
    public function login(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
		
		$array = ['email' => $request->email, 'password' => $request->password];
		
		if (Auth::attempt($array)) 
		{
			$now = Carbon::now()->addDays(1);
			$user = Auth::user(); 
			$token = $user->createToken($user->name);
			$data['token'] = $token->token->id;
			
			return $this->sendResponse(true, $data, 'Successfully login');
		}
		else
		{
			return $this->sendError('Error while login', []);
		}
	}
	
	public function logout(Request $request)
	{	
		$token = $request->bearerToken();
		$cekdata = DB::table('oauth_access_tokens')->where('id', $token)->delete();
		Session::flush();
		return $this->sendResponse(true, [], 'Account successfully logout');
	}
	
	public function randomquote()
	{
		$data = DB::table('quote')->get()->random(1);
		$array = [
			'quote' => $data[0]->quote,
			'source' => $data[0]->url,
		];
		return $this->sendResponse(true, $array, 'Random quote from api.chucknorris.io');
		/* 
			//Solusi lain (no database. api only) : 
			$response = Http::get('https://api.chucknorris.io/jokes/random');
			$decode = $response->json();
			$array = [
				'quote' => $decode['value'],
				'source' => $decode['url'],
			];
			return $this->sendResponse(true, $array, 'Random quote from api.chucknorris.io');
		 */
	}
}
