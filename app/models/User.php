<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * Add attributes to user model
	 * @var array
	 */
	protected $appends = array('is_admin', 'is_writer', 'is_reader');

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

	/**
	 * This attribute specified user is admin or not
	 * @return bool
	 */
	public function getIsAdminAttribute()
	{
		$project = Project::getProjectByUrl(Route::Input('project'));
		if ($project)
		{
			$admins = explode(',', $project->admins);
			if (in_array(Auth::id(), $admins))
			{
				return $this->attributes['is_admin'] = true;
			}
			return $this->attributes['is_admin'] = false;
		}
	}

	/**
	* This attribute specified user is write or not
	* @return bool
	*/
	public function getIsWriterAttribute()
	{
		$project = Project::getProjectByUrl(Route::Input('project'));
		if ($project)
		{
			$writers = explode(',', $project->writers);
			if (in_array(Auth::id(), $writers))
			{
				return $this->attributes['is_writer'] = true;
			}
			return $this->attributes['is_writer'] = false;
		}
	}

	/**
	* This attribute specified user is reader or not
	* @return bool
	*/
	public function getIsReaderAttribute()
	{
		$project = Project::getProjectByUrl(Route::Input('project'));
		if ($project)
		{
			$readers = explode(',', $project->readers);
			if (in_array(Auth::id(), $readers))
			{
				return $this->attributes['is_reader'] = true;
			}
			return $this->attributes['is_reader'] = false;
		}
	}

	/**
	 * Get id of groups permission
	 * @param $projectId int
	 * @return array
	 */
	public static function getGroupIdName($users)
	{
		$users = explode(",", $users);
		$usersArray = array();
		foreach ($users as $user)
		{
			$user = User::find($user);
			if ($user)
				$usersArray[] = array('name' => $user->name, 'user_id' => $user->user_id);
		}
		return $usersArray;
	}
}
