@extends('layouts.milestone.main')

@section('title')
    {{$project->name}} - {{$project->milestone->codename}} - {{$project->milestone->blueprint->title}}
@stop

@section('menu-mid')
    <li class="active"><a>{{trans('layout.blueprint')}}</a></li>
@stop

@section('content')
    <div class="col-md-12">
        <h3>Blueprint: {{$project->milestone->blueprint->title}} #{{$project->milestone->blueprint->blueprint_id}}</h3>
        <p>{{$project->milestone->blueprint->description}}</p>
        @if (Session::has('message'))
            <p class="text-info">{{Session::get('message')}}</p>
        @endif
        <div class="col-md-6">
            <div class="col-md-6">
                <table class="table table-clear">
                    <tbody>
                        <tr>
                            <td><b>{{trans('layout.registred_by')}}<b></td>
                            <td>{{$project->milestone->blueprint->user_created->name}}</td>
                        </tr>
                        <tr>
                            <td><b>{{trans('layout.assign_to')}}</b></td>
                            <td>{{isset($project->milestone->blueprint->user_assigned->name) ? $project->milestone->blueprint->user_assigned->name : 'Not Assigned'}}</td>
                        </tr>
                        <tr>
                            <td><b>{{trans('layout.created_at')}}</b></td>
                            <td>{{(new Carbon\Carbon($project->milestone->blueprint->created_at))->diffForHumans(Carbon\Carbon::now())}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-clear">
                    <tbody>
                        <tr>
                            <td><b>{{trans('layout.importance')}}<b></td>
                            <td style="color: {{Helper::getBlueprintImportanceColor($project->milestone->blueprint->importance)}}">
                                {{Helper::getBlueprintImportance($project->milestone->blueprint->importance)}}
                            </td>
                        </tr>
                        <tr>
                            <td><b>{{trans('layout.status')}}</b></td>
                            <td style="color: {{Helper::getBlueprintStatusColor($project->milestone->blueprint->status)}}">
                                {{Helper::getBlueprintStatus($project->milestone->blueprint->status)}}
                            </td>
                        </tr>
                        <tr>
                            <td><b>{{trans('layout.updated_at')}}</b></td>
                            <td>{{(new Carbon\Carbon($project->milestone->blueprint->updated_at))->diffForHumans(Carbon\Carbon::now())}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
                @if (Auth::user()->is_admin)
                    <a class="pull-right btn btn-default" href="{{URL::action('MilestoneController@getUpdateBlueprint', array($project->url, $project->milestone->url, $project->milestone->blueprint->blueprint_id))}}">Update</a>
                @endif
            </div>
            <div class="col-md-12">
                @foreach ($project->milestone->blueprint->events as $event)
                    <div class="event">
                        <h5>{{User::find($event->user_id)->name}} in {{(new Carbon\Carbon($event->created_at))->diffForHumans(Carbon\Carbon::now())}}</h5>
                        @if (!empty($event->changes))
                            <p><b>{{trans('layout.changes')}}</b></p>
                            <ul class="changes">
                                {{$event->changes}}
                            </ul>
                        @endif
                        @if (!empty($event->description))
                            <p><b>{{trans('layout.desc')}}</b></p>
                            <p class="description">{{$event->description}}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <h4>{{trans('layout.related_bugs')}}</h4>
            <ul>
                @foreach ($project->milestone->blueprint->bugs as $bug)
                    <li>
                        <a href="{{URL::action('MilestoneController@getBug', array($project->url, $project->milestone->url, $bug->bug_id))}}">{{$bug->title}}</a>
                        [
                            <span style="color: {{Helper::getBugImportanceColor($bug->importance)}}">{{Helper::getBugImportance($bug->importance)}}</span>
                            <span style="color: {{Helper::getBugStatusColor($bug->status)}}">, {{Helper::getBugStatus($bug->status)}}</span>
                        ]
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@stop
