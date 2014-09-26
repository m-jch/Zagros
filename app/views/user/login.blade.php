@extends('layouts.guest.main')

@section('title')
    {{trans('layout.zagros')}}::{{trans('layout.bts')}}
@stop

@section('content')
    <div class="col-md-6 col-md-offset-3">
        <h2 class="text-center">{{trans('layout.login')}}</h2>
        @if (Session::has('message'))
            <p class="text-info text-center">{{Session::get('message')}}</p>
        @endif
        {{Form::open(array('class' => 'form-horizontal', 'role' => 'form'))}}
            <div class="form-group">
                {{Form::label('email', trans('layout.email'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    {{Form::email('email', '', array('class' => 'form-control', 'placeholder' => trans('layout.email'), 'id' => 'email'))}}
                    {{$errors->first('email', '<small class="text-warning">:message</small>')}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('password', trans('layout.password'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    {{Form::password('password', array('class' => 'form-control', 'placeholder' => trans('layout.password'), 'id' => 'password'))}}
                    {{$errors->first('password', '<small class="text-warning">:message</small><br>')}}
                    <small><a href="">{{trans('layout.recover_pw')}}</a></small>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label>
                            {{Form::checkbox('remember', 'on')}} {{trans('layout.remember')}}
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    {{Form::submit(trans('layout.sign_in'), array('class' => 'btn btn-default'))}}
                </div>
            </div>
        {{Form::close()}}
    </div>
@stop
