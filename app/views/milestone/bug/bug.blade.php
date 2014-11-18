@extends('layouts.milestone.main')

@section('title')
    {{$project->name}} - {{$project->milestone->codename}} - {{$project->milestone->bug->title}}
@stop

@section('menu-mid')
    <li class="active"><a>{{trans('layout.bug')}}</a></li>
@stop

@section('content')
    <div class="col-md-12">
        <h3>Bug: {{{$project->milestone->bug->title}}} #{{$project->milestone->bug->bug_id}}</h3>
        <p>{{$project->milestone->bug->description}}</p>
        @if (Session::has('message'))
            <p class="text-info">{{Session::get('message')}}</p>
        @endif
        <div class="col-md-6">
            <div class="col-md-6">
                <table class="table table-clear">
                    <tbody>
                        <tr>
                            <td><b>{{trans('layout.registred_by')}}<b></td>
                            <td>{{$project->milestone->bug->user_created->name}}</td>
                        </tr>
                        <tr>
                            <td><b>{{trans('layout.assign_to')}}</b></td>
                            <td>{{isset($project->milestone->bug->user_assigned->name) ? $project->milestone->bug->user_assigned->name : 'Not Assigned'}}</td>
                        </tr>
                        <tr>
                            <td><b>{{trans('layout.created_at')}}</b></td>
                            <td>{{(new Carbon\Carbon($project->milestone->bug->created_at))->diffForHumans(Carbon\Carbon::now())}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-clear">
                    <tbody>
                        <tr>
                            <td><b>{{trans('layout.importance')}}<b></td>
                            <td style="color: {{Helper::getBugImportanceColor($project->milestone->bug->importance)}}">
                                {{Helper::getBugImportance($project->milestone->bug->importance)}}
                            </td>
                        </tr>
                        <tr>
                            <td><b>{{trans('layout.status')}}</b></td>
                            <td style="color: {{Helper::getBugStatusColor($project->milestone->bug->status)}}">
                                {{Helper::getBugStatus($project->milestone->bug->status)}}
                            </td>
                        </tr>
                        <tr>
                            <td><b>{{trans('layout.updated_at')}}</b></td>
                            <td>{{(new Carbon\Carbon($project->milestone->bug->updated_at))->diffForHumans(Carbon\Carbon::now())}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
                @if (Auth::user()->is_admin)
                    <a class="pull-right btn btn-default" href="{{URL::action('MilestoneController@getUpdateBug', array($project->url, $project->milestone->url, $project->milestone->bug->bug_id))}}">Update</a>
                @endif
            </div>
            <div class="col-md-12">
                @foreach ($project->milestone->bug->events as $event)
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
            <h4>{{trans('layout.blueprint_parent')}}</h4>
            <ul>
                @if (isset($project->milestone->bug->parent))
                    <li>
                        <a href="{{URL::action('MilestoneController@getBlueprint', array($project->url, $project->milestone->url, $project->milestone->bug->parent->blueprint_id))}}">{{$project->milestone->bug->parent->title}}</a>
                        [
                            <span style="color: {{Helper::getBlueprintImportanceColor($project->milestone->bug->parent->importance)}}">{{Helper::getBlueprintImportance($project->milestone->bug->parent->importance)}}</span>
                            <span style="color: {{Helper::getBlueprintStatusColor($project->milestone->bug->parent->status)}}">, {{Helper::getBlueprintStatus($project->milestone->bug->parent->status)}}</span>
                        ]
                    </li>
                @else
                    <li>{{trans('layout.no_parent')}}</li>
                @endif
            </ul>
        </div>
    </div>
@stop
