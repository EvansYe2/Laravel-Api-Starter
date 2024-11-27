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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group(['prefix'=>'v1','namespace'=>'App\Api\V1\Controllers'],function($router) {
    $router->post('auth/login', 'AuthController@login');

    $router->group(['middleware'=>['refresh','auth:api']],function ($api) {
        $api->get('auth/me', 'AuthController@me');
        $api->post('auth/refresh', 'AuthController@refresh');
        $api->get('auth/me', 'AuthController@me');
    });
});
