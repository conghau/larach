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

Route::get('/', function () {
    return view('welcome');
});


/**
 * |--------------------------------------------------------------------------
 * | Admin route - START
 * |--------------------------------------------------------------------------
 */

Route::group(['prefix' => 'cpadmin', 'middleware' => ['web'], 'namespace' => 'App\Http\Controllers\Admin'], function ($router) {

    Route::get('/login', 'AuthController@showFormLogin');

    /*Settings*/
    $router->controller('settings', 'SettingController');
    /*Menus*/
    $router->controller('menus', 'MenuController');
});

/**
 * |--------------------------------------------------------------------------
 * | Admin route - END
 * |--------------------------------------------------------------------------
 */

Event::listen('illuminate.query',function($query){
    var_dump($query);
});