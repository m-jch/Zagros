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
        'codename' => 'required|max:100|unique:milestones,codename',
        'version' => 'max:50',
        'release_date' => 'max:100',
        'description' => ''
    );

    /**
     * Rules for project
     * @var array
     */
    public static $rules = array(
        'codename' => 'required|max:100|unique:milestones',
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
}
