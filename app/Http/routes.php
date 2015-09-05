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

Route::get('/', 'MessagesController@showMessages');

Route::get('view', 'MessagesController@showMessages');

Route::get('view/{board_id}', 'MessagesController@showMessages');

Route::post('post', 'MessagesController@processPostMessage');

Route::post('post/{board_id}', 'MessagesController@processPostMessage');

Route::get('/{board_id}', 'MessagesController@showMessages');
