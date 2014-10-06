@extends('layouts.milestone.main')

@section('title')
    {{trans('layout.zagros')}}::{{$milestone->codename}}
@stop

@section('milestone-navbar')active @stop

@section('content')
    <div class="col-md-12">
        <h3>Bug: {{$bug->title}} #{{$bug->bug_id}}</h3>
        <p>{{$bug->description}}</p>
        @if (Session::has('message'))
            <p class="text-info">{{Session::get('message')}}</p>
        @endif
        <div class="col-md-6">
            <div class="col-md-6">
                <table class="table table-clear">
                    <tbody>
                        <tr>
                            <td><b>Registred by:<b></td>
                            <td>{{$bug->user_created->name}}</td>
                        </tr>
                        <tr>
                            <td><b>Assign to:</b></td>
                            <td>{{isset($bug->user_assigned->name) ? $bug->user_assigned->name : 'Not Assigned'}}</td>
                        </tr>
                        <tr>
                            <td><b>Created at:</b></td>
                            <td>{{(new Carbon\Carbon($bug->created_at))->diffForHumans(Carbon\Carbon::now())}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-clear">
                    <tbody>
                        <tr>
                            <td><b>Importance:<b></td>
                            <td style="color: {{Helper::getBugImportanceColor($bug->importance)}}">
                                {{Helper::getBugImportance($bug->importance)}}
                            </td>
                        </tr>
                        <tr>
                            <td><b>Status:</b></td>
                            <td style="color: {{Helper::getBugStatusColor($bug->status)}}">
                                {{Helper::getBugStatus($bug->status)}}
                            </td>
                        </tr>
                        <tr>
                            <td><b>Updated at:</b></td>
                            <td>{{(new Carbon\Carbon($bug->updated_at))->diffForHumans(Carbon\Carbon::now())}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
                @if (Auth::user()->is_admin)
                    <a class="pull-right btn btn-default" href="{{URL::action('MilestoneController@getUpdateBug', array($project->url, $milestone->url, $bug->bug_id))}}">Update</a>
                @endif
            </div>
            <div class="col-md-12">
                @foreach ($bug->events as $event)
                    <div class="event">
                        <h5>{{User::find($event->user_id)->name}} in {{(new Carbon\Carbon($event->created_at))->diffForHumans(Carbon\Carbon::now())}}</h5>
                        @if (!empty($event->changes))
                            <p><b>Changes:</b></p>
                            <ul class="changes">
                                {{$event->changes}}
                            </ul>
                        @endif
                        @if (!empty($event->description))
                            <p><b>Description:</b></p>
                            <p class="description">{{$event->description}}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <h4>Blueprint Parent</h4>
            <ul>
                @if (isset($bug->parent->title))
                    <li>
                        <a href="{{URL::action('MilestoneController@getBlueprint', array($project->url, $milestone->url, $bug->parent->blueprint_id))}}">{{$bug->parent->title}}</a>
                        [
                            <span style="color: {{Helper::getBlueprintImportanceColor($bug->parent->importance)}}">{{Helper::getBlueprintImportance($bug->parent->importance)}}</span>
                            <span style="color: {{Helper::getBlueprintStatusColor($bug->parent->status)}}">, {{Helper::getBlueprintStatus($bug->parent->status)}}</span>
                        ]
                    </li>
                @else
                    <li>No parent</li>
                @endif
            </ul>
        </div>
    </div>
@stop
