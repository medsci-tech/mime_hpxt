<?php

//use Illuminate\Http\Request;
use Dingo\Api\Http\FormRequest;
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
// V1 版本，公有接口
// API 路由接管
$api = app('api.router');
$api->version('v1', function ($api) {
    $api->group(['namespace' => 'App\Http\Controllers\Api\V1','middleware' => []], function ($api) {

    });
    $api->group(['prefix' => 'user','namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {
    $api->post('/', 'UserController@store'); // 注册

    $api->get('tests/{id}', 'TestsController@show');
    $api->get('user/me', 'AuthController@AuthenticatedUser'); //根据
    });

});



//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
