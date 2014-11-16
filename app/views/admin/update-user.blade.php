@extends('layouts.user.main')

@section('title')
    {{trans('layout.zagros')}}::{{trans('layout.admin')}}
@stop

@section('admin-navbar')active @stop

@section('content')
    <div class="col-md-6 col-md-offset-3">
        <h2 class="text-center">{{trans('layout.update_user')}}</h2>
        @if (Session::has('message'))
            <p class="text-info text-center">{{Session::get('message')}}</p>
        @endif
        {{Form::open(array('action' => 'AdminController@postCreateUser', 'class' => 'form-horizontal', 'role' => 'form'))}}
            <div class="form-group">
                {{Form::label('email', trans('layout.email'), array('class' => 'col-sm-3 control-label'))}}
                <div class="col-sm-8">
                    {{Form::email('email', $user->email, array('class' => 'form-control', 'placeholder' => trans('layout.email'), 'id' => 'email'))}}
                    {{$errors->first('email', '<small class="text-warning">:message</small>')}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('name', trans('layout.name'), array('class' => 'col-sm-3 control-label'))}}
                <div class="col-sm-8">
                    {{Form::text('name', $user->name, array('class' => 'form-control', 'placeholder' => trans('layout.name'), 'id' => 'name'))}}
                    {{$errors->first('name', '<small class="text-warning">:message</small>')}}
                </div>
            </div>
            <hr>
            <div class="form-group">
                {{Form::label('password', trans('layout.password'), array('class' => 'col-sm-3 control-label'))}}
                <div class="col-sm-8">
                    {{Form::password('password', array('class' => 'form-control', 'placeholder' => trans('layout.password'), 'id' => 'password'))}}
                    {{$errors->first('password', '<small class="text-warning">:message</small><br>')}}
                    <small class="text-warning">{{trans('messages.change_password')}}</small>
                </div>
            </div>
            <div class="form-group">
                {{Form::label('cpassword', trans('layout.cpassword'), array('class' => 'col-sm-3 control-label'))}}
                <div class="col-sm-8">
                    {{Form::password('cpassword', array('class' => 'form-control', 'placeholder' => trans('layout.cpassword'), 'id' => 'cpassword'))}}
                    {{$errors->first('cpassword', '<small class="text-warning">:message</small>')}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('admin', trans('layout.admin'), array('class' => 'col-sm-3 control-label'))}}
                <div class="col-sm-8">
                    {{Form::checkbox('admin', 'true', $user->admin, array('class' => '', 'id' => 'admin'))}}
                    {{$errors->first('admin', '<small class="text-warning">:message</small>')}}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10 text-center">
                    {{Form::hidden('user_id', $user->user_id)}}
                    {{Form::hidden('update', 'true')}}
                    {{Form::submit(trans('layout.update_user'), array('class' => 'btn btn-primary'))}}
                </div>
            </div>
        {{Form::close()}}
    </div>
@stop

@section('footer')
    <script>
        $(function() {
            var admins = $('#admins, #writers, #readers').magicSuggest({
                data: '{{URL::action('AdminController@postUsers')}}',
                valueField: 'user_id',
                displayField: 'name',
                mode: 'remote',
                allowFreeEntries: false,
                renderer: function(data){
                    return '<div class="users">' +
                            '<div class="name">' + data.name + '</div>' +
                           '</div>';
                },
                resultAsString: true,
                selectionRenderer: function(data){
                    return '<div class="name">' + data.name + '</div>';
                }
            });
        });
    </script>
@stop
