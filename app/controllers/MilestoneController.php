<?php

class MilestoneController extends BaseController
{

    public function __construct()
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('valid-project-user');
        $this->beforeFilter('admin-project', array('only' => array('getCreateBlueprint')));
        $this->beforeFilter('not-reader', array('only' => array('getCreateBug')));
        $this->beforeFilter('csrf', array('only' => array()));
    }

    public function getIndex($projectUrl, $milestoneUrl)
    {
        $project = Project::getProjectByUrl($projectUrl);
        $milestone = Milestone::where('url', $milestoneUrl)->with(array('blueprints' => function($query)
        {
            $query->orderBy('importance', 'asc')->orderBy('status', 'asc')->get();
        }))->first();

        return View::make('milestone.list')->with(array(
            'project' => $project,
            'milestone' => $milestone
        ));
    }

    public function getCreateBlueprint($projectUrl, $milestoneUrl)
    {
        $project = Project::getProjectByUrl($projectUrl);
        $milestone = Milestone::where('url', $milestoneUrl)->first();

        return View::make('milestone.create-blueprint')->with(array(
            'project' => $project,
            'milestone' => $milestone
        ));
    }

    public function postCreateBlueprint($projectUrl, $milestoneUrl)
    {
        $project = Project::getProjectByUrl($projectUrl);
        $milestone = Milestone::where('url', $milestoneUrl)->first();

        if (!is_null(Input::get('update')))
        {
            $blueprint = Blueprint::find(Input::get('blueprint_id'));
            $message = trans('messages.update_blueprint');
        }
        else
        {
            $blueprint = new Blueprint;
            $message = trans('messages.create_blueprint');
        }

        if (!$blueprint)
        {
            return Redirect::action('MilestoneController@getIndex', array($project->url, $milestone->url))->with('message', trans('messages.form_error'));
        }

        $v = Validator::make(Input::all(), Blueprint::getRules(Input::get('update'), $blueprint->blueprint_id));
        if ($v->fails())
        {
            return Redirect::back()->withErrors($v)->withInput()->with('message', trans('messages.form_error'));
        }

        $blueprint->title = Input::get('title');
        $blueprint->description = Input::get('description');
        $blueprint->user_id_assigned = (null !== Input::get('user_id_assigned')) ? Input::get('user_id_assigned')[0] : null;
        $blueprint->user_id_created = Auth::id();
        $blueprint->status = Input::get('status');
        $blueprint->importance = Input::get('importance');
        $blueprint->project_id = $project->project_id;

        $milestone->blueprints()->save($blueprint);

        return Redirect::action('MilestoneController@getIndex', array($project->url, $milestone->url))->with('message', $message);
    }

    public function getCreateBug($projectUrl, $milestoneUrl)
    {

    }

    public function postUsers($projectUrl, $milestoneUrl)
    {
        $project = Project::getProjectByUrl($projectUrl);
        $admins = empty($project->admins) ? array() : explode(',', $project->admins);
        $writers = empty($project->writers) ? array() : explode(',', $project->writers);
        $readers = empty($project->readers) ? array() : explode(',', $project->readers);
        $users = array_merge($admins, $writers, $readers);

        $usersModels = array();

        foreach($users as $user)
        {
            array_push($usersModels, User::select('name', 'user_id')->find($user));
        }

        return $usersModels;
    }
}
