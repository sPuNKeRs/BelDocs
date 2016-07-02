<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', [
	'as' => 'mainpage',
	'uses' => 'PagesController@mainpage',
	'middleware' => ['logged']	
]);


Route::group(['middleware' => ['logged']], function (){
	Route::get('/orders', [
		'as' => 'orders.all',
		'uses' => 'PagesController@orders_all'
	]);
});
