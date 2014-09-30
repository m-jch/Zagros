@extends('layouts.project.main')

@section('title')
    {{trans('layout.zagros')}}::{{trans('layout.milestones')}}
@stop

@section('admin-navbar')active @stop

@section('content')
    <div class="col-md-6 col-md-offset-3">
        <h2 class="text-center">{{trans('layout.milestones')}}</h2>
        @if (Session::has('message'))
            <p class="text-info text-center">{{Session::get('message')}}</p>
        @endif
        {{Form::open(array('action' => array('ProjectController@postCreate', $project->url), 'class' => 'form-horizontal', 'role' => 'form'))}}
            <div class="form-group">
                {{Form::label('codename', trans('layout.codename'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    {{Form::text('codename', '', array('class' => 'form-control', 'placeholder' => trans('layout.codename'), 'id' => 'codename'))}}
                    {{$errors->first('codename', '<small class="text-warning">:message</small>')}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('version', trans('layout.version'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    {{Form::text('version', '', array('class' => 'form-control', 'placeholder' => trans('layout.version'), 'id' => 'version'))}}
                    {{$errors->first('version', '<small class="text-warning">:message</small>')}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('release-date', trans('layout.release_date'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    {{Form::text('release_date', '', array('class' => 'form-control', 'placeholder' => trans('layout.release_date'), 'id' => 'release-date'))}}
                    {{$errors->first('release_date', '<small class="text-warning">:message</small><br>')}}
                    <small class="text-info">Leave empty if not released yet.</small>
                </div>
            </div>
            <div class="form-group">
                {{Form::label('desc', trans('layout.desc'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    {{Form::textarea('description', '', array('class' => 'form-control', 'placeholder' => trans('layout.desc'), 'id' => 'desc'))}}
                    {{$errors->first('description', '<small class="text-warning">:message</small>')}}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10 text-center">
                    {{Form::submit(trans('layout.create'), array('class' => 'btn btn-primary'))}}
                </div>
            </div>
        {{Form::close()}}
    </div>
@stop
