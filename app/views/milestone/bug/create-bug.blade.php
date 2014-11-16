@extends('layouts.milestone.main')

@section('title')
    {{$project->name}} - {{$project->milestone->codename}} - {{trans('layout.cnbug')}}
@stop

@section('menu-mid')
    <li class="active"><a>{{trans('layout.cnbug')}}</a></li>
@stop

@section('content')
    <div class="col-md-6 col-md-offset-3">
        <h2 class="text-center">{{trans('layout.cnbug')}}</h2>
        @if (Session::has('message'))
            <p class="text-info text-center">{{Session::get('message')}}</p>
        @endif
        {{Form::open(array('action' => array('MilestoneController@postCreateBug', $project->url, $project->milestone->url), 'class' => 'form-horizontal', 'role' => 'form'))}}
            <div class="form-group">
                {{Form::label('title', trans('layout.title'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    {{Form::text('title', '', array('class' => 'form-control', 'placeholder' => trans('layout.title'), 'id' => 'title'))}}
                    {{$errors->first('title', '<small class="text-warning">:message</small>')}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('status', trans('layout.status'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    {{Form::select('status', Helper::getBugStatus(), 0, array('class' => 'form-control'))}}
                    {{$errors->first('status', '<small class="text-warning">:message</small>')}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('importance', trans('layout.importance'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    {{Form::select('importance', Helper::getBugImportance(), 2, array('class' => 'form-control'))}}
                    {{$errors->first('importance', '<small class="text-warning">:message</small><br>')}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('desc', trans('layout.desc'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    {{Form::textarea('description', '', array('class' => 'form-control', 'placeholder' => trans('layout.desc'), 'id' => 'desc'))}}
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
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10 text-center">
                    {{Form::submit(trans('layout.create'), array('class' => 'btn btn-primary'))}}
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
                valueField: 'blueprint_id',
                displayField: 'title',
                mode: 'remote',
                allowFreeEntries: false,
                maxSelection: 1,
                renderer: function(data){
                    return '<div class="users">' +
                            '<div class="name">#' + data.blueprint_id + ' ' + data.title + '</div>' +
                           '</div>';
                },
                resultAsString: true,
                selectionRenderer: function(data){
                    return '<div class="name">#' + data.blueprint_id + ' ' + data.title + '</div>';
                }
            });
        });
    </script>
@stop
