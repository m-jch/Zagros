@extends('layouts.milestone.main')

@section('title')
    {{trans('layout.zagros')}}::{{$milestone->codename}}
@stop

@section('blueprint-navbar')active @stop

@section('content')
    <div class="col-md-6 col-md-offset-3">
        <h2 class="text-center">{{trans('layout.cnb')}}</h2>
        @if (Session::has('message'))
            <p class="text-info text-center">{{Session::get('message')}}</p>
        @endif
        {{Form::open(array('action' => array('MilestoneController@postCreateBlueprint', $project->url, $milestone->url), 'class' => 'form-horizontal', 'role' => 'form'))}}
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
                    {{Form::select('status', Helper::getBlueprintStatus(), 0, array('class' => 'form-control'))}}
                    {{$errors->first('status', '<small class="text-warning">:message</small>')}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('importance', trans('layout.importance'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    {{Form::select('importance', Helper::getBlueprintImportance(), 2, array('class' => 'form-control'))}}
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
            var admins = $('#assign').magicSuggest({
                data: '{{URL::action('MilestoneController@postUsers', array($project->url, $milestone->url))}}',
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
        });
    </script>
@stop
