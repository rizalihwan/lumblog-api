<?php

$router->group(['prefix' => 'posts', 'namespace' => 'Admin'], function () use ($router) {
    $router->get('/', 'PostController@index');
    $router->post('/store', 'PostController@store');
});