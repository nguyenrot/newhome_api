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

Route::prefix('category')->group(function (){
    Route::get('/',[
        'as'=>'all_category',
        'uses'=>'App\Http\Controllers\Api\CategoryController@index',
    ]);
    Route::get('/{id}',[
        'as'=>'get_category',
        'uses'=>'App\Http\Controllers\Api\CategoryController@get',
    ]);
    Route::patch('/{id}',[
        'as'=>'post_category',
        'uses'=>'App\Http\Controllers\Api\CategoryController@patch',
    ])->middleware('auth:sanctum','checkadmin');
    Route::post('/',[
        'as'=>'create_category',
        'uses'=>'App\Http\Controllers\Api\CategoryController@create',
    ])->middleware('auth:sanctum','checkadmin');
    Route::delete('/{id}',[
        'as'=>'create_category',
        'uses'=>'App\Http\Controllers\Api\CategoryController@delete',
    ])->middleware('auth:sanctum','checkadmin');
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
    Route::post('/login',[
        'as' => 'login',
        'uses' => 'App\Http\Controllers\Api\AuthController@login',
    ]);
    Route::get('/current_user',[
        'as' => 'current_user',
        'uses' => 'App\Http\Controllers\Api\AuthController@getCurrentUser',
    ])->middleware('auth:sanctum');
    Route::post('/logout',[
        'as' => 'logout',
        'uses' => 'App\Http\Controllers\Api\AuthController@logout',
    ])->middleware('auth:sanctum');
});
