<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/user/login', 'ExampleController@postLogin'); 
$router->post('/user/register', 'ExampleController@postRegister'); 
$router->get('/user/search', 'ExampleController@getUsers'); 

$router->group(['middleware' => "auth"] , function($router){
	$router->get('/test', 'ExampleController@testAuthenticate'); 
});

Route::group(['middleware' => ['jwt.auth', 'jwt.refresh']], function($router){
	$router->get('/token/destroy', 'ExampleController@logout'); 
});


