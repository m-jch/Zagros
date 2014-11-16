@extends('layouts.guest.main')

@section('title')
    {{trans('layout.zagros')}}::{{trans('layout.register')}}
@stop

@section('register-navbar')active @stop

@section('content')
    <div class="col-md-6 col-md-offset-3">
        <h2 class="text-center">{{trans('layout.register')}}</h2>
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
                {{Form::label('name', trans('layout.name'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    {{Form::text('name', '', array('class' => 'form-control', 'placeholder' => trans('layout.name'), 'id' => 'name'))}}
                    {{$errors->first('name', '<small class="text-warning">:message</small>')}}
                </div>
            </div>
            <hr>
            <div class="form-group">
                {{Form::label('password', trans('layout.password'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    {{Form::password('password', array('class' => 'form-control', 'placeholder' => trans('layout.password'), 'id' => 'password'))}}
                    {{$errors->first('password', '<small class="text-warning">:message</small>')}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('password', trans('layout.cpassword'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    {{Form::password('cpassword', array('class' => 'form-control', 'placeholder' => trans('layout.cpassword'), 'id' => 'password'))}}
                    {{$errors->first('cpassword', '<small class="text-warning">:message</small>')}}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    {{Form::submit(trans('layout.register'), array('class' => 'btn btn-default'))}}
                </div>
            </div>
        {{Form::close()}}
    </div>
@stop
