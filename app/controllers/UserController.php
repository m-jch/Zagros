<?php

class UserController extends BaseController
{

    public function __construct()
    {
        $this->beforeFilter('guest', array('except' => 'getLogout'));
    }

    public function getIndex()
    {

    }

    public function getLogin()
    {
        return View::make('user.login');
    }

    public function postLogin()
    {
        $v = Validator::make(Input::all(), User::$loginRules);
        if ($v->fails())
        {
            return Redirect::back()->withErrors($v)->withInput()->with('message', trans('messages.form_error'));
        }

        if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password')), Input::get('remember')))
        {
            Event::fire('user.login');
            return Redirect::action('HomeController@getIndex');
        }
        return Redirect::back()->withInput()->with('message', trans('messages.login_error'));
    }

    public function getRegister()
    {
        return View::make('user.register');
    }

    public function postRegister()
    {
        $v = Validator::make(Input::all(), User::$registerRules);
        if ($v->fails())
        {
            return Redirect::back()->withErrors($v)->withInput()->with('message', trans('messages.form_error'));
        }

        $user = new User;
        $user->email = Input::get('email');
        $user->name = Input::get('name');
        $user->password = Hash::make(Input::get('password'));
        Event::fire('user.register', $user);
        $user->save();

        return Redirect::action('UserController@getLogin')->with('message', trans('messages.register_success'));
    }

    public function getLogout()
    {
        Auth::logout();
        return Redirect::to('/');
    }
}
