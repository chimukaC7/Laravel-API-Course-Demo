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


//unprotected routes
Route::post('auth/register', [App\Http\Controllers\Api\V1\Auth\RegisterController::class]);
Route::post('auth/login', [App\Http\Controllers\Api\V1\Auth\LoginController::class]);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::get('/user', function (Request $request) {
////    dd($request);
//    return $request->user();
//});

//Route::get('categories', 'Api\CategoryController@index');
//Route::get('categories/{category}', 'Api\CategoryController@show');
//Route::post('categories', 'Api\CategoryController@store');
//Route::put('categories/{category}', 'Api\CategoryController@update');
//Route::delete('categories/{category}', 'Api\CategoryController@destroy');

Route::apiResource('categories', 'Api\CategoryController')
    ->middleware('auth:sanctum');

//Route::get('products', [App\Http\Controllers\Api\ProductController::class ,'index']);
Route::get('products', [App\Http\Controllers\Api\V1\ProductController::class ,'index']);

Route::group(['middleware' => 'throttle:2,1'], function (){
    Route::apiResource('categories', 'Api\CategoryController')
        ->middleware('auth:sanctum');
});
