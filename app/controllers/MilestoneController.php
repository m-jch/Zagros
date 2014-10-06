<?php

class MilestoneController extends BaseController
{

    public function __construct()
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('valid-project-user');
        $this->beforeFilter('valid-milestone');
        $this->beforeFilter('admin-project', array('only' => array('getCreateBlueprint', 'postCreateBlueprint', 'getDeleteBlueprint', 'getUpdateBlueprint')));
        $this->beforeFilter('not-reader', array('only' => array('getCreateBug')));
        $this->beforeFilter('csrf', array('only' => array()));
    }

    public function getIndex($projectUrl, $milestoneUrl)
    {
        $project = Project::getProjectByUrl($projectUrl);
        $milestone = Milestone::where('url', $milestoneUrl)->with(array('blueprints' => function($query)
        {
            $query->orderBy('status', 'asc')->orderBy('importance', 'asc')->with('userAssigned')->get();
        }, 'bugs' => function($query)
        {
            $query->orderBy('status', 'asc')->orderBy('importance', 'asc')->with('userAssigned')->get();
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
            $oldBlueprint = $blueprint->toArray();
            $message = trans('messages.update_blueprint');
        }
        else
        {
            $blueprint = new Blueprint;
            $blueprint->user_id_created = Auth::id();
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
        $blueprint->status = Input::get('status');
        $blueprint->importance = Input::get('importance');
        $blueprint->project_id = $project->project_id;

        $milestone->blueprints()->save($blueprint);
        if (!is_null(Input::get('update')))
        {
            $this->updatedBlueprint($oldBlueprint, $blueprint, $project->project_id, $milestone->milestone_id, Input::get('description_update'));
        }

        return Redirect::action('MilestoneController@getBlueprint', array($project->url, $milestone->url, $blueprint->blueprint_id))->with('message', $message);
    }

    public function getUpdateBlueprint($projectUrl, $milestoneUrl, $blueprintId)
    {
        $project = Project::getProjectByUrl($projectUrl);
        $milestone = Milestone::getMilestoneByUrl($milestoneUrl);
        $blueprint = Blueprint::where('blueprint_id', $blueprintId)->with('userAssigned', 'userCreated')->first();

        if (!$blueprint)
        {
            return Redirect::action('MilestoneController@getIndex', array($project->url, $milestone->url))->with('message', trans('messages.form_error'));
        }

        return View::make('milestone.update-blueprint')->with(array(
            'project' => $project,
            'milestone' => $milestone,
            'blueprint' => $blueprint
        ));
    }

    public function getDeleteBlueprint($projectUrl, $milestoneUrl, $blueprintId)
    {
        $project = Project::getProjectByUrl($projectUrl);
        $milestone = Milestone::getMilestoneByUrl($milestoneUrl);
        $blueprint = Blueprint::find($blueprintId);

        if ($blueprint)
        {
            $blueprint->delete();
            return Redirect::action('MilestoneController@getIndex', array($project->url, $milestone->url))->with('message', trans('messages.delete_blueprint'));
        }

        return Redirect::action('MilestoneController@getIndex', array($project->url, $milestone->url))->with('message', trans('messages.form_error'));
    }

    public function getBlueprint($projectUrl, $milestoneUrl, $blueprintId)
    {
        $project = Project::getProjectByUrl($projectUrl);
        $milestone = Milestone::getMilestoneByUrl($milestoneUrl);
        $blueprint = Blueprint::where('blueprint_id', $blueprintId)->with('userAssigned', 'userCreated', 'events', 'bugs')->first();

        if (!$blueprint)
        {
            return Redirect::action('MilestoneController@getIndex', array($project->url, $milestone->url))->with('message', trans('messages.form_error'));
        }

        return View::make('milestone.blueprint.blueprint')->with(array(
            'project' => $project,
            'milestone' => $milestone,
            'blueprint' => $blueprint
        ));
    }

    protected function updatedBlueprint($oldBlueprint, $newBlueprint, $projectId, $milestoneId, $description)
    {
        $changes = '';
        if ($oldBlueprint['status'] !== $newBlueprint->status)
            $changes .= '<li>'.Auth::user()->name.' change status from '.Helper::getBlueprintStatus($oldBlueprint['status']).' to '.Helper::getBlueprintStatus($newBlueprint->status).'</li>';

        if ($oldBlueprint['importance'] !== $newBlueprint->importance)
            $changes .= '<li>'.Auth::user()->name.' change importance from '.Helper::getBlueprintImportance($oldBlueprint['importance']).' to '.Helper::getBlueprintImportance($newBlueprint->importance).'</li>';

        if ($oldBlueprint['title'] !== $newBlueprint->title)
            $changes .= '<li>'.Auth::user()->name.' change title from <i>'.$oldBlueprint['title'].'</i> to <i>'.$newBlueprint->title.'</i></li>';

        if ($oldBlueprint['description'] !== $newBlueprint->description)
            $changes .= '<li>'.Auth::user()->name.' change description';

        if ($oldBlueprint['user_id_assigned'] !== $newBlueprint->user_id_assigned)
        {
            $oldUser = !empty($oldBlueprint['user_id_assigned']) ? User::find($oldBlueprint['user_id_assigned'])->name : 'None';
            $newUser = !empty($newBlueprint->user_id_assigned) ? User::find($newBlueprint->user_id_assigned)->name : 'None';
            $changes .= '<li>'.Auth::user()->name.' change assigned from '.$oldUser.' to '.$newUser.'</li>';
        }

        if (!empty($changes) || !empty($description))
        {
            $event = new Events;
            $event->user_id = Auth::id();
            $event->project_id = $projectId;
            $event->milestone_id = $milestoneId;
            $event->blueprint_id = $newBlueprint->blueprint_id;
            $event->changes = $changes;
            $event->description = $description;
            $event->save();
        }
    }

    public function getCreateBug($projectUrl, $milestoneUrl)
    {
        $project = Project::getProjectByUrl($projectUrl);
        $milestone = Milestone::getMilestoneByUrl($milestoneUrl)->first();

        return View::make('milestone.bug.create-bug')->with(array(
            'project' => $project,
            'milestone' => $milestone
        ));
    }

    public function postCreateBug($projectUrl, $milestoneUrl)
    {
        $project = Project::getProjectByUrl($projectUrl);
        $milestone = Milestone::getMilestoneByUrl($milestoneUrl);

        if (!is_null(Input::get('update')))
        {
            $bug = Bug::find(Input::get('bug_id'));
            $oldBug = $bug->toArray();
            $message = trans('messages.update_bug');
        }
        else
        {
            $bug = new Bug;
            $bug->user_id_created = Auth::id();
            $message = trans('messages.create_bug');
        }

        if (!$bug)
        {
            return Redirect::action('MilestoneController@getIndex', array($project->url, $milestone->url))->with('message', trans('messages.form_error'));
        }

        $v = Validator::make(Input::all(), Bug::getRules(Input::get('update'), $bug->bug_id));
        if ($v->fails())
        {
            return Redirect::back()->withErrors($v)->withInput()->with('message', trans('messages.form_error'));
        }

        $bug->title = Input::get('title');
        $bug->description = Input::get('description');
        $bug->user_id_assigned = (null !== Input::get('user_id_assigned')) ? Input::get('user_id_assigned')[0] : null;
        $bug->status = Input::get('status');
        $bug->importance = Input::get('importance');
        $bug->project_id = $project->project_id;
        $bug->blueprint_id = (null !== Input::get('blueprint_id')) ? Input::get('blueprint_id')[0] : null;

        $milestone->bugs()->save($bug);
        if (!is_null(Input::get('update')))
        {
            $this->updatedBug($oldBug, $bug, $project->project_id, $milestone->milestone_id, Input::get('description_update'));
        }

        return Redirect::action('MilestoneController@getBug', array($project->url, $milestone->url, $bug->bug_id))->with('message', $message);
    }

    public function getBug($projectUrl, $milestoneUrl, $bugId)
    {
        $project = Project::getProjectByUrl($projectUrl);
        $milestone = Milestone::getMilestoneByUrl($milestoneUrl);
        $bug = Bug::where('bug_id', $bugId)->with('userAssigned', 'userCreated', 'events', 'parent')->first();

        if (!$bug)
        {
            return Redirect::action('MilestoneController@getIndex', array($project->url, $milestone->url))->with('message', trans('messages.form_error'));
        }

        return View::make('milestone.bug.bug')->with(array(
            'project' => $project,
            'milestone' => $milestone,
            'bug' => $bug
        ));
    }

    public function getUpdateBug($projectUrl, $milestoneUrl, $bugId)
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

    public function postBlueprints($projectUrl, $milestoneUrl)
    {
        $project = Project::getProjectByUrl($projectUrl);
        $milestone = Milestone::where('url', $milestoneUrl)->with('blueprints')->first();

        return $milestone->blueprints;
    }
}
