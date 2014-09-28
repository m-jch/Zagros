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
        if (!is_null(Input::get('update')))
        {
            $project = Project::find(Input::get('project_id'));
        }
        else
        {
            $project = new Project;
        }

        if (!$project)
        {
            return Redirect::action('HomeController@getIndex')->with('message', trans('messages.form_error'));
        }

        $v = Validator::make(Input::all(), Project::getRules(Input::get('update'), $project->project_id));
        if ($v->fails())
        {
            return Redirect::back()->withErrors($v)->withInput()->with('message', trans('messages.form_error'));
        }

        $admins = is_array(Input::get('admins')) ? Input::get('admins') : array();
        $writers = is_array(Input::get('writers')) ? Input::get('writers') : array();
        $readers = is_array(Input::get('readers')) ? Input::get('readers') : array();

        $writers = Project::removeElementFromArray($admins, $writers);
        $readers = Project::removeElementFromArray(array_merge($admins, $writers), $readers);


        $project->name = Input::get('name');
        $project->repository = Input::get('repository');
        $project->description = Input::get('description');

        $project->admins = implode(',', $admins);
        $project->writers = implode(',', $writers);
        $project->readers = implode(',', $readers);

        $project->save();

        return Redirect::action('HomeController@getIndex')->with('message', trans('messages.create_project'));
    }

    public function getUpdateProject($id = null)
    {
        $project = Project::find($id);

        if ($project)
        {
            $admins = User::getGroupIdName($project->admins);
            $writers = User::getGroupIdName($project->writers);
            $readers = User::getGroupIdName($project->readers);

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
