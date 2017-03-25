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

Route::any('/test', function(){
  return "test ok";
});

Route::any('/login', 'Api\PenggunaController@loginCheck');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    //return $request->user();
});
