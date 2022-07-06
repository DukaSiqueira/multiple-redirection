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

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('create-link', ['uses' => 'LinkController@create']);
    $router->post('create-link-redirect', ['uses' => 'LinkController@createLinkRedirect']);
    $router->put('edit-link-gerado', ['uses' => 'LinkController@editLinkGerado']);
    $router->put('edit-link-gerado', ['uses' => 'LinkController@editLinkRedirecionamento']);
});
