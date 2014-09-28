<?php

Route::controller('user', 'UserController');
Route::controller('admin', 'AdminController');
Route::controller('{project}/milestones', 'ProjectController');
Route::controller('{project}/{milestone}', 'MilestoneController');

Route::get('/', array('before' => 'auth', 'uses' => 'HomeController@getIndex'));
