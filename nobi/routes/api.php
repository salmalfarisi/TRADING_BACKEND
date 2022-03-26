<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['as' => 'users.'], function () {
	Route::post('auth/register', 'UsersController@register')->name('register');
	Route::post('auth/login', 'UsersController@login')->name('login');
	Route::get('quote', 'UsersController@randomquote')->name('randomquote');
});


Route::group(['middleware' => 'token'], function () {
	Route::get('auth/logout', 'UsersController@logout')->name('logout');
	Route::group(['as' => 'transaction.'], function () {
		Route::post('transaction', 'TransactionController@store')->name('store');
	});
	Route::group(['as' => 'CoinPrice.'], function () {
		Route::post('price/upload', 'CoinPriceController@store')->name('store');
		Route::post('price/low-high', 'CoinPriceController@filteringminmax')->name('filteringminmax');
		Route::post('price/history', 'CoinPriceController@history')->name('history');
	});
});
