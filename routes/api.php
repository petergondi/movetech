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
 Route::middleware('auth:api')->get('/user', function (Request $request) {
   return $request->user();
 });
 
//Route::post('callback','GuestCustomerHomeController@callback')->middleware('apiauth');
// Route::group(['middleware' => 'auth:api'], function(){
//  Route::post('callback','GuestCustomerHomeController@callback');
//   });
Route::middleware('auth:api')->post('callback','GuestCustomerHomeController@callback' );//->header('Content-Type', 'application/json');