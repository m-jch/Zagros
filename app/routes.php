<?php

Route::controller('user', 'UserController');
Route::controller('admin', 'AdminController');

//Define getIndex routes for delete /index from url
Route::get('{project}/milestones', 'ProjectController@getIndex');
Route::get('{project}/{milestone}', 'MilestoneController@getIndex');

Route::controller('{project}/milestones', 'ProjectController');
Route::controller('{project}/{milestone}', 'MilestoneController');

//Define index route
Route::get('/', array('before' => 'auth', 'uses' => 'HomeController@getIndex'));
