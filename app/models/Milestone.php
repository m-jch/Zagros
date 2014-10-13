<?php

class Milestone extends Eloquent
{
    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'milestones';

    /**
     * Primary key of users table
     * @var string
     */
    protected $primaryKey = 'milestone_id';

    /**
     * Rules for project
     * @var array
     */
    public static $updateRules = array(
        'codename' => 'required|max:100|not_in:milestones|unique:milestones,codename',
        'version' => 'max:50',
        'release_date' => 'max:100',
        'description' => ''
    );

    /**
     * Rules for project
     * @var array
     */
    public static $rules = array(
        'codename' => 'required|max:100|not_in:milestones|unique:milestones',
        'version' => 'max:50',
        'release_date' => 'max:100',
        'description' => ''
    );

    /**
     * Get rules for new or update
     * @param $update string|null
     * @param $id string|null
     * @return array
     */
    public static function getRules($update, $id)
    {
        if (is_null($update))
        {
            return static::$rules;
        }
        static::$updateRules['codename'] .= ','.$id.',milestone_id';
        return static::$updateRules;
    }

    /**
     * Access to milestone by url's
     * @param $url string
     * @return mixed|null
     */
    public static function getMilestoneByUrl($url)
    {
        return Milestone::where('url', $url)->first();
    }

    /**
     * Access to blueprints of a milestone
     */
    public function blueprints()
    {
        return $this->hasMany('Blueprint', 'milestone_id', 'milestone_id');
    }

    /**
     * Access to blueprint of a milestone
     */
    public function blueprint()
    {
        return $this->hasOne('Blueprint', 'milestone_id', 'milestone_id');
    }

    /**
     * Access to bugs of a milestone
     */
    public function bugs()
    {
        return $this->hasMany('Bug', 'milestone_id', 'milestone_id');
    }

    /**
     * Access to bug of a milestone
     */
    public function bug()
    {
        return $this->hasOne('Bug', 'milestone_id', 'milestone_id');
    }
}
