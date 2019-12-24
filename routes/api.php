<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', 'API\ProductController@index');
Route::post('/order-service', 'API\OrderController@prepare');
Route::put('/order-service', 'API\OrderController@store');

// Only for test purposes
Route::get('/orders', function () {
	dump(App\Order::with('products')
		->with('services')
		->get()
		->toArray()
	);
});
