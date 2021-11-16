<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('location')->group(function (){
    Route::get('/',[
        'as'=>'location',
        'uses'=>'App\Http\Controllers\Api\LocationController@index',
    ]);
    Route::get('/{id}',[
        'as'=>'location',
        'uses'=>'App\Http\Controllers\Api\LocationController@city_id',
    ]);
    Route::get('/{id_city}/{id}',[
        'as'=>'location',
        'uses'=>'App\Http\Controllers\Api\LocationController@district_id',
    ]);
});

Route::prefix('auth')->group(function (){
    Route::post('/register',[
        'as' => 'register',
        'uses' => 'App\Http\Controllers\Api\AuthController@register',
    ]);
});
