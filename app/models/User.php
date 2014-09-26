<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	/**
	 * Primary key of users table
	 * @var string
	 */
	protected $primaryKey = 'user_id';

	/**
	 * Rules for register user
	 * @var array
	 */
	public static $registerRules = array(
		'email' => 'required|email|unique:users',
		'name' => 'required|max:20|unique:users',
		'password' => 'required|min:6|max:16',
		'cpassword' => 'required|same:password'
	);

	/**
	 * Rules for user login
	 * @var array
	 */
	public static $loginRules = array(
		'email' => 'required|exists:users',
		'password' => 'required'
	);

}
