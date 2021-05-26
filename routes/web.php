<?php

$router->group(['prefix' => 'posts', 'namespace' => 'Admin'], function () use ($router) {
    $router->get('/', 'PostController@index');
    $router->post('/store', 'PostController@store');
    $router->get('/show/{id}', 'PostController@show');
    $router->patch('/update/{id}', 'PostController@update');
    $router->delete('/delete/{id}', 'PostController@destroy');
});