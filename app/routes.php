<?php

Route::controller('user', 'UserController');
Route::controller('admin', 'AdminController');

Route::get('/', array('before' => 'auth', 'uses' => 'HomeController@getIndex'));
