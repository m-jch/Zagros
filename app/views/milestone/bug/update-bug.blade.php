@extends('layouts.milestone.main')

@section('title')
    {{trans('layout.zagros')}}::{{$project->milestone->codename}}
@stop

@section('milestone-navbar')active @stop

@section('content')
    <div class="col-md-6 col-md-offset-3">
        <h2 class="text-center">{{trans('layout.update_bug')}}</h2>
        @if (Session::has('message'))
            <p class="text-info text-center">{{Session::get('message')}}</p>
        @endif
        {{Form::open(array('action' => array('MilestoneController@postCreateBug', $project->url, $project->milestone->url), 'class' => 'form-horizontal', 'role' => 'form'))}}
            <div class="form-group">
                {{Form::label('title', trans('layout.title'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    {{Form::text('title', $project->milestone->bug->title, array('class' => 'form-control', 'placeholder' => trans('layout.title'), 'id' => 'title'))}}
                    {{$errors->first('title', '<small class="text-warning">:message</small>')}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('status', trans('layout.status'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    {{Form::select('status', Helper::getBugStatus(), $project->milestone->bug->status, array('class' => 'form-control'))}}
                    {{$errors->first('status', '<small class="text-warning">:message</small>')}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('importance', trans('layout.importance'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    {{Form::select('importance', Helper::getBugImportance(), $project->milestone->bug->importance, array('class' => 'form-control'))}}
                    {{$errors->first('importance', '<small class="text-warning">:message</small><br>')}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('desc', trans('layout.desc'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    {{Form::textarea('description', str_replace('<br />', '', $project->milestone->bug->description), array('class' => 'form-control', 'placeholder' => trans('layout.desc'), 'id' => 'desc'))}}
                    {{$errors->first('description', '<small class="text-warning">:message</small>')}}
                </div>
            </div>
            <hr>
            <div class="form-group">
                {{Form::label('parent', trans('layout.parent'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    <input type="text" name="blueprint_id" id="parent" class="form-control" placeholder="{{trans('layout.parent')}}">
                    {{$errors->first('blueprint_id', '<small class="text-warning">:message</small><br>')}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('assign', trans('layout.assign'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    <input type="text" name="user_id_assigned" id="assign" class="form-control" placeholder="{{trans('layout.assign')}}">
                    {{$errors->first('user_id_assigned', '<small class="text-warning">:message</small><br>')}}
                </div>
            </div>
            <hr>
            <div class="form-group">
                {{Form::label('des-update', trans('layout.desc_update'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    {{Form::textarea('description_update', '', array('class' => 'form-control', 'placeholder' => trans('layout.desc_update'), 'id' => 'desc_update'))}}
                    {{$errors->first('description_update', '<small class="text-warning">:message</small>')}}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10 text-center">
                    {{Form::hidden('update', 'true')}}
                    {{Form::hidden('bug_id', $project->milestone->bug->bug_id)}}
                    {{Form::submit(trans('layout.update'), array('class' => 'btn btn-primary'))}}
                    @if (Auth::user()->is_admin)
                        <a href="{{URL::action('MilestoneController@getDeleteBug', array($project->url, $project->milestone->url, $project->milestone->bug->bug_id))}}?_token={{csrf_token()}}" class="btn btn-danger"
                            onclick="if(!confirm('{{trans('messages.delete')}}')) return event.preventDefault();">{{trans('layout.delete_bug')}}</a>
                    @endif
                </div>
            </div>
        {{Form::close()}}
    </div>
@stop

@section('footer')
    <script>
        $(function() {
            var assign = $('#assign').magicSuggest({
                data: '{{URL::action('MilestoneController@postUsers', array($project->url, $project->milestone->url))}}',
                @if (isset($project->milestone->bug->user_assigned->user_id))
                    value: [{user_id: "{{$project->milestone->bug->user_assigned->user_id}}", name: "{{$project->milestone->bug->user_assigned->name}}"}],
                @endif
                valueField: 'user_id',
                displayField: 'name',
                mode: 'remote',
                allowFreeEntries: false,
                maxSelection: 1,
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

            var parent = $('#parent').magicSuggest({
                data: '{{URL::action('MilestoneController@postBlueprints', array($project->url, $project->milestone->url))}}',
                @if (isset($project->milestone->bug->parent->blueprint_id))
                    value: [{blueprint_id: "{{$project->milestone->bug->parent->blueprint_id}}", title: "{{$project->milestone->bug->parent->title}}"}],
                @endif
                valueField: 'blueprint_id',
                displayField: 'title',
                mode: 'remote',
                allowFreeEntries: false,
                maxSelection: 1,
                renderer: function(data){
                    return '<div class="users">' +
                            '<div class="name">' + data.title + '</div>' +
                           '</div>';
                },
                resultAsString: true,
                selectionRenderer: function(data){
                    return '<div class="name">' + data.title + '</div>';
                }
            });
        });
    </script>
@stop
