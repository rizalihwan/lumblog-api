<?php

// user endpoints
$router->group(['prefix' => 'user'], function() use ($router) {
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
    $router->post('/logout', 'AuthController@logout');
    $router->get('/me', 'AuthController@me');
});

// blog endpoints
$router->group(['prefix' => 'posts', 'namespace' => 'Admin', 'middleware' => 'auth:api'], function () use ($router) {
    $router->get('/', 'PostController@index');
    $router->post('/store', 'PostController@store');
    $router->get('/show/{id}', 'PostController@show');
    $router->patch('/update/{id}', 'PostController@update');
    $router->delete('/delete/{id}', 'PostController@destroy');
});