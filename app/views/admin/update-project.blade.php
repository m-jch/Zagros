@extends('layouts.user.main')

@section('title')
    {{trans('layout.zagros')}}::{{trans('layout.admin')}}
@stop

@section('admin-navbar')active @stop

@section('content')
    <div class="col-md-6 col-md-offset-3">
        <h2 class="text-center">{{trans('layout.update_project')}} {{$project->name}}</h2>
        @if (Session::has('message'))
            <p class="text-info text-center">{{Session::get('message')}}</p>
        @endif
        {{Form::open(array('action' => 'AdminController@postCreateProject', 'class' => 'form-horizontal', 'role' => 'form'))}}
            <div class="form-group">
                {{Form::label('name', trans('layout.name'), array('class' => 'col-sm-3 control-label'))}}
                <div class="col-sm-8">
                    {{Form::text('name', $project->name, array('class' => 'form-control', 'placeholder' => trans('layout.name'), 'id' => 'name'))}}
                    {{$errors->first('name', '<small class="text-warning">:message</small>')}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('name', trans('layout.repo_url'), array('class' => 'col-sm-3 control-label'))}}
                <div class="col-sm-8">
                    {{Form::text('repository', $project->repository, array('class' => 'form-control', 'placeholder' => trans('layout.repo_url'), 'id' => 'repository'))}}
                    {{$errors->first('repository', '<small class="text-warning">:message</small>')}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('desc', trans('layout.desc'), array('class' => 'col-sm-3 control-label'))}}
                <div class="col-sm-8">
                    {{Form::textarea('description', $project->description, array('class' => 'form-control', 'placeholder' => trans('layout.desc'), 'id' => 'description'))}}
                    {{$errors->first('description', '<small class="text-warning">:message</small><br>')}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('admins', trans('layout.admins'), array('class' => 'col-sm-3 control-label'))}}
                <div class="col-sm-8">
                    <input type="text" name="admins[]" id="admins" class="form-control" placeholder="{{trans('layout.admins')}}">
                    {{$errors->first('admins', '<small class="text-warning">:message</small><br>')}}
                    <small class="text-info">{{trans('messages.new_project_admins')}}</small>
                </div>
            </div>
            <div class="form-group">
                {{Form::label('writers', trans('layout.writers'), array('class' => 'col-sm-3 control-label'))}}
                <div class="col-sm-8">
                    <input type="text" name="writers[]" id="writers" class="form-control" placeholder="{{trans('layout.writers')}}">
                    {{$errors->first('writers', '<small class="text-warning">:message</small><br>')}}
                    <small class="text-info">{{trans('messages.new_project_writers')}}</small>
                </div>
            </div>
            <div class="form-group">
                {{Form::label('readers', trans('layout.readers'), array('class' => 'col-sm-3 control-label'))}}
                <div class="col-sm-8">
                    <input type="text" name="readers[]" id="readers" class="form-control" placeholder="{{trans('layout.readers')}}">
                    {{$errors->first('readers', '<small class="text-warning">:message</small><br>')}}
                    <small class="text-info">{{trans('messages.new_project_readers')}}</small>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10 text-center">
                    {{Form::hidden('update', 'true')}}
                    {{Form::hidden('project_id', $project->project_id)}}
                    {{Form::submit(trans('layout.update'), array('class' => 'btn btn-primary'))}}
                    <a href="{{URL::action('AdminController@getDeleteProject', $project->project_id)}}?_token={{csrf_token()}}" class="btn btn-danger"
                        onclick="if(!confirm('{{trans('messages.delete')}}')) return event.preventDefault();">{{trans('layout.delete_project')}}</a>
                </div>
            </div>
        {{Form::close()}}
    </div>
@stop

@section('footer')
    <script>
        $(function() {
            var admins = $('#admins').magicSuggest({
                data: '{{URL::action('AdminController@postUsers')}}',
                value: {{json_encode($admins)}},
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
            var writers = $('#writers').magicSuggest({
                data: '{{URL::action('AdminController@postUsers')}}',
                value: {{json_encode($writers)}},
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
            var readers = $('#readers').magicSuggest({
                data: '{{URL::action('AdminController@postUsers')}}',
                value: {{json_encode($readers)}},
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
