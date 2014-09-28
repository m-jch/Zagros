<?php

class Project extends Eloquent
{
    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'projects';

    /**
     * Primary key of users table
     * @var string
     */
    protected $primaryKey = 'project_id';

    /**
     * Rules for project
     * @var array
     */
    public static $updateRules = array(
        'name' => 'required|max:100|unique:projects,name',
        'repository' => 'max:500|url',
        'description' => ''
    );

    /**
     * Rules for project
     * @var array
     */
    public static $rules = array(
        'name' => 'required|max:100|unique:projects',
        'repository' => 'max:500|url',
        'description' => ''
    );

    public static function getRules($update, $id)
    {
        if (is_null($update))
        {
            return static::$rules;
        }
        static::$updateRules['name'] .= ','.$id.',project_id';
        return static::$updateRules;
    }

    /**
     * For example remove admins from writers array
     * @param $elements array
     * @param $array array
     * @return array
     */
    public static function removeElementFromArray($elements, $array)
    {
        if (is_array($elements) && is_array($array))
        {
            foreach ($elements as $element)
            {
                if (in_array($element, $array))
                {
                    $key = array_search($element, $array);
                    unset($array[$key]);
                }
            }
        }
        return $array;
    }
}
