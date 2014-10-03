<?php

class Events extends Eloquent
{
    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'events';

    /**
     * Primary key of users table
     * @var string
     */
    protected $primaryKey = 'event_id';
}
