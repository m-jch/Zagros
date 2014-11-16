<?php

class AdminController extends BaseController
{

    public function __construct()
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('admin');
        $this->beforeFilter('csrf', array('only' => array('getDeleteProject')));
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
            $message = trans('messages.create_project');
        }
        else
        {
            $project = new Project;
            $message = trans('messages.update_project');
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
        $project->url = Str::slug(Input::get('name'));
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
        return View::make('admin.create-user');
    }

    public function postCreateUser()
    {
        if (!is_null(Input::get('update')))
        {
            $user = User::find(Input::get('user_id'));
            $message = trans('messages.update_user');
        }
        else
        {
            $user = new User;
            $message = trans('messages.create_user');
        }

        if (!$user)
        {
            return Redirect::back()->withErrors($v)->withInput()->with('message', trans('messages.form_error'));
        }

        $v = Validator::make(Input::all(), User::getRules(Input::get('update'), $user->user_id));
        if ($v->fails())
        {
            return Redirect::back()->withErrors($v)->withInput()->with('message', trans('messages.form_error'));
        }

        $user->email = Input::get('email');
        $user->name = Input::get('name');
        if (Input::has('password'))
            $user->password = Hash::make(Input::get('password'));
        $user->admin = (Input::get('admin') == 'true') ? 1 : 0;
        $user->save();
        if (!is_null(Input::get('update')))
            Event::fire('user.register', $user);
        else
            Event::fire('user.update', $user);

        return Redirect::action('AdminController@getUsersList')->with('message', $message);
    }

    public function getDeleteProject($id)
    {
        $project = Project::find($id);
        if ($project)
        {
            $project->delete();
            return Redirect::to('/')->with('message', trans('messages.delete_project'));
        }
        return Redirect::to('/')->with('message', trans('messages.form_error'));
    }

    public function getUpdateUser($userId)
    {
        $user = User::findOrFail($userId);
        return View::make('admin.update-user', array(
            'user' => $user
        ));
    }

    public function getDeleteUser($userId)
    {
        $user = User::findOrFail($userId);

        $users = User::all(array('name', 'user_id'))->keyBy('user_id')->toArray();
        unset($users[$user->user_id]);
        foreach ($users as $key => $u)
            $users[$key] = $u['name'];

        return View::make('admin.delete-user', array(
            'user' => $user,
            'users' => $users
        ));
    }

    public function postDeleteUser()
    {
        $user = User::findOrFail(Input::get('user_id'));

        $rule = array(
            'new_user' => 'required|exists:users,user_id|not_in:'.$user->user_id,
            'user_id' => 'not_in:'.Auth::id()
        );
        $v = Validator::make(Input::all(), $rule);
        if ($v->fails())
            return Redirect::action('AdminController@getUsersList')->with('message', trans('messages.form_error'));

        $newUser = Input::get('new_user');

        $projects = Project::orWhere('admins', 'LIKE', '%'.$user->user_id.'%')
                                    ->orWhere('writers', 'LIKE', '%'.$user->user_id.'%')
                                    ->orWhere('readers', 'LIKE', '%'.$user->user_id.'%')
                                    ->get();

        foreach ($projects as $project)
        {
            $admins = explode(',', $project->admins);
            if ($index = in_array($user->user_id, $admins) !== false)
            {
                unset($admins[array_search($user->user_id, $admins)]);
                $project->admins = implode(',', $admins);
            }

            $writers = explode(',', $project->writers);
            if ($index = in_array($user->user_id, $writers) !== false)
            {
                unset($writers[array_search($user->user_id, $writers)]);
                $project->writers = implode(',', $writers);
            }

            $readers = explode(',', $project->readers);
            if ($index = in_array($user->user_id, $readers) !== false)
            {
                unset($readers[array_search($user->user_id, $readers)]);
                $project->readers = implode(',', $readers);
            }

            $project->save();
        }

        Blueprint::where('user_id_created', $user->user_id)->update(array('user_id_created' => $newUser));
        Blueprint::where('user_id_assigned', $user->user_id)->update(array('user_id_assigned' => null));

        Bug::where('user_id_created', $user->user_id)->update(array('user_id_created' => $newUser));
        Bug::where('user_id_assigned', $user->user_id)->update(array('user_id_assigned' => null));

        Events::where('user_id', $user->user_id)->update(array('user_id' => $newUser));

        $user->delete();

        return Redirect::action('AdminController@getUsersList')->with('message', trans('messages.delete_user'));
    }

    public function postUsers()
    {
        $query = Input::get('query');
        $users = User::select('name', 'user_id')->where('name', 'like', '%'.$query.'%')->get()->toJson();
        return $users;
    }

    public function getUsersList()
    {
        if (Input::has('q') && !empty(Input::get('q')))
        {
            $usersPaginate = User::orderBy('admin', 'desc')
                                    ->orderBy('name', 'asc')
                                    ->where('name', 'LIKE', '%'.Input::get('q').'%')
                                    ->paginate(15);
            $users = $usersPaginate->keyBy('user_id')->toArray();
        }
        else
        {
            $usersPaginate = User::orderBy('admin', 'desc')->orderBy('name', 'asc')->paginate(15);
            $users = $usersPaginate->keyBy('user_id')->toArray();
        }

        $projects = Project::all();

        foreach ($projects as $project)
        {
            $admins = (explode(',', $project->admins)[0] === '') ? array() : explode(',', $project->admins);
            foreach ($admins as $admin)
                if (array_key_exists($admin, $users))
                    $users[$admin]['admin_projects'][] = $project->name;

            $writers = (explode(',', $project->writers)[0] === '') ? array() : explode(',', $project->writers);
            foreach ($writers as $writer)
                if (array_key_exists($writer, $users))
                    $users[$writer]['writer_projects'][] = $project->name;

            $readers = (explode(',', $project->readers)[0] === '') ? array() : explode(',', $project->readers);
            foreach ($readers as $reader)
                if (array_key_exists($reader, $users))
                    $users[$reader]['reader_projects'][] = $project->name;
        }

        return View::make('admin.users-list', array(
            'users' => $users,
            'paginate' => $usersPaginate
        ));
    }
}
