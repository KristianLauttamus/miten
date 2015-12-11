<?php

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

$app->get('/', 'GuideController@getIndex');
$app->get('guides/create', 'GuideController@getCreate');
$app->post('guides/create', 'GuideController@postCreate');

// User
$app->get('login', 'AuthController@getLogin');
$app->post('login', 'AuthController@postLogin');
$app->get('register', 'AuthController@getRegister');
$app->post('register', 'AuthController@postRegister');

// Guides
$app->get('/list', function () use ($app) {
    return view('list');
});
$app->get('/show', function () use ($app) {
    return view('show');
});
$app->get('/edit', function () use ($app) {
    return view('edit');
});
