<?php

class AdminController extends BaseController
{

    public function __construct()
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('admin');
    }

    public function getCreateProject()
    {
        return View::make('admin.create-project');
    }

    public function postCreateProject()
    {
        $v = Validator::make(Input::all(), Project::getRules(Input::get('update')));
        if ($v->fails())
        {
            return Redirect::back()->withErrors($v)->withInput()->with('message', trans('messages.form_error'));
        }

        $admins = is_array(Input::get('admins')) ? Input::get('admins') : array();
        $writers = is_array(Input::get('writers')) ? Input::get('writers') : array();
        $readers = is_array(Input::get('readers')) ? Input::get('readers') : array();

        $writers = Project::removeElementFromArray($admins, $writers);
        $readers = Project::removeElementFromArray(array_merge($admins, $writers), $readers);

        if (!is_null(Input::get('update')))
        {
            $project = Project::find(Input::get('project_id'));
        }
        else
        {
            $project = new Project;
        }
        $project->name = Input::get('name');
        $project->repository = Input::get('repository');
        $project->description = Input::get('description');
        $project->save();

        $user = User::find(Auth::id());
        if ($user)
        {
            $projects_admin_id = json_decode($user->projects_admin_id, true);
            $projects_admin_id[$project->project_id] = $project->project_id;
            $user->projects_admin_id = json_encode($projects_admin_id);
            $user->save();
        }

        if (!is_null(Input::get('update')))
        {
            $usres = User::getProjectUsers($project->project_id);

        }

        foreach ($admins as $admin)
        {
            $user = User::find($admin);
            if ($user)
            {
                $projects_admin_id = json_decode($user->projects_admin_id, true);
                $projects_admin_id[$project->project_id] = $project->project_id;
                $user->projects_admin_id = json_encode($projects_admin_id);
                $user->save();
            }
        }

        foreach ($writers as $writer)
        {
            $user = User::find($writer);
            if ($user)
            {
                $projects_write_id = json_decode($user->projects_write_id, true);
                $projects_write_id[$project->project_id] = $project->project_id;
                $user->projects_write_id = json_encode($projects_write_id);
                $user->save();
            }
        }

        foreach ($readers as $reader)
        {
            $user = User::find($reader);
            if ($user)
            {
                $projects_read_id = json_decode($user->projects_read_id, true);
                $projects_read_id[$project->project_id] = $project->project_id;
                $user->projects_read_id = json_encode($projects_read_id);
                $user->save();
            }
        }

        return Redirect::action('HomeController@getIndex')->with('message', trans('messages.create_project'));
    }

    public function getUpdateProject($id = null)
    {
        $project = Project::find($id);
        $admins = User::getGroupIdName('admin', $project->project_id);
        $writers = User::getGroupIdName('write', $project->project_id);
        $readers = User::getGroupIdName('read', $project->project_id);

        if ($project)
        {
            return View::make('admin.update-project')->with(array(
                'project' => $project,
                'admins' => $admins,
                'writers' => $writers,
                'readers' => $readers
            ));
        }
        return Redirect::action('HomeController@getIndex')->with('message', trans('messages.form_error'));
    }

    public function getCreateUser()
    {

    }

    public function postUsers()
    {
        $query = Input::get('query');
        $users = User::select('name', 'user_id')->where('name', 'like', '%'.$query.'%')->get()->toJson();
        return $users;
    }
}
