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
        $api->get('tests', 'TestsController@index');
        $api->get('users','TestsController@users');
    });
});
//$api = app('Dingo\Api\Routing\Router');
//$api->version('v1', function ($api) {
//    $api->group(['namespace' => 'App\Http\Controllers\Api','middleware' => ['']], function ($api) {
//            //路径为 /api/tests
//            $api->get('tests', 'TestsController@index');
//        });
//    });

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
