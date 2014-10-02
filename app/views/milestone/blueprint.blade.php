@extends('layouts.milestone.main')

@section('title')
    {{trans('layout.zagros')}}::{{$milestone->codename}}
@stop

@section('blueprint-navbar')active @stop

@section('content')
    <div class="col-md-12">
        <h3>Blueprint: {{$blueprint->title}} #{{$blueprint->blueprint_id}}</h3>
        <p>{{$blueprint->description}}</p>
        @if (Session::has('message'))
            <p class="text-info">{{Session::get('message')}}</p>
        @endif
        <div class="col-md-6">
            <div class="col-md-6">
                <table class="table table-clear">
                    <tbody>
                        <tr>
                            <td><b>Registred by:<b></td>
                            <td>{{$blueprint->user_created->name}}</td>
                        </tr>
                        <tr>
                            <td><b>Assign to:</b></td>
                            <td>{{isset($blueprint->user_assigned->name) ? $blueprint->user_assigned->name : 'Not Assigned'}}</td>
                        </tr>
                        <tr>
                            <td><b>Created at:</b></td>
                            <td>{{(new Carbon\Carbon($blueprint->created_at))->diffForHumans(Carbon\Carbon::now())}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-clear">
                    <tbody>
                        <tr>
                            <td><b>Importance:<b></td>
                            <td style="color: {{Helper::getBlueprintImportanceColor($blueprint->importance)}}">
                                {{Helper::getBlueprintImportance($blueprint->importance)}}
                            </td>
                        </tr>
                        <tr>
                            <td><b>Status:</b></td>
                            <td style="color: {{Helper::getBlueprintStatusColor($blueprint->importance)}}">
                                {{Helper::getBlueprintStatus($blueprint->importance)}}
                            </td>
                        </tr>
                        <tr>
                            <td><b>Updated at:</b></td>
                            <td>{{(new Carbon\Carbon($blueprint->updated_at))->diffForHumans(Carbon\Carbon::now())}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @if (!Auth::user()->is_reader)
                <a class="pull-right btn btn-default" href="{{URL::action('MilestoneController@getUpdateBlueprint', array($project->url, $milestone->url, $blueprint->blueprint_id))}}">Update</a>
            @endif
        </div>
        <div class="col-md-6">
            <h4>Related bugs</h4>
        </div>
    </div>
@stop
