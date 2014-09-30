<?php

class ProjectController extends BaseController
{

    public function __construct()
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('valid-project-user');
        $this->beforeFilter('admin-project', array('only' => array('getCreate', 'postCreate', 'getEdit', 'getDeleteMilestone')));
        $this->beforeFilter('csrf', array('only' => array('getDeleteMilestone')));
    }

    public function getIndex($projectUrl)
    {
        $project = Project::where('url', $projectUrl)->with('milestones')->first();

        return View::make('project.milestone.list')->with(array(
            'project' => $project
        ));
    }

    public function getCreate($projectUrl)
    {
        $project = Project::getProjectByUrl($projectUrl);

        return View::make('project.milestone.create')->with(array(
            'project' => $project
        ));
    }

    public function postCreate($projectUrl)
    {
        $project = Project::getProjectByUrl($projectUrl);
        if (!is_null(Input::get('update')))
        {
            $milestone = Milestone::find(Input::get('milestone_id'));
            $message = trans('messages.update_milestone');
        }
        else
        {
            $milestone = new Milestone;
            $message = trans('messages.create_milestone');
        }

        if (!$milestone)
        {
            return Redirect::action('ProjectController@getIndex', $project->url)->with('message', trans('messages.form_error'));
        }

        $v = Validator::make(Input::all(), Milestone::getRules(Input::get('update'), $milestone->milestone_id));
        if ($v->fails())
        {
            return Redirect::back()->withErrors($v)->withInput()->with('message', trans('messages.form_error'));
        }

        $milestone->codename = Input::get('codename');
        $milestone->url = Helper::slugify(Input::get('codename'));
        $milestone->version = Input::get('version');
        $milestone->release_date = Input::get('release_date');
        $milestone->description = Input::get('description');

        $project->milestones()->save($milestone);

        return Redirect::action('ProjectController@getIndex', $project->url)->with('message', $message);
    }

    public function getEdit($projectUrl, $id)
    {
        $project = Project::getProjectByUrl($projectUrl);
        $milestone = Milestone::find($id);

        return View::make('project.milestone.edit')->with(array(
            'project' => $project,
            'milestone' => $milestone
        ));
    }

    public function getDeleteMilestone($projectUrl, $id)
    {
        $project = Project::getProjectByUrl($projectUrl);
        $milestone = Milestone::find($id);
        if ($milestone)
        {
            $milestone->delete();
            return Redirect::action('ProjectController@getIndex', $project->url)->with('message', trans('messages.delete_milestone'));
        }
        return Redirect::action('ProjectController@getIndex', $project->url)->with('message', trans('messages.form_error'));
    }
}
