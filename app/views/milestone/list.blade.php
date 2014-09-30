@extends('layouts.milestone.main')

@section('title')
    {{trans('layout.zagros')}}::{{$milestone->codename}}
@stop

@section('milestone-navbar')active @stop

@section('content')
    <div class="col-md-6 col-md-offset-3">
        <h2 class="text-center">{{$milestone->codename}}</h2>
        @if (Session::has('message'))
            <p class="text-info text-center">{{Session::get('message')}}</p>
        @endif
    </div>

    <div class="col-md-12">
        <h3 class="text-center">Blueprints</h3>
        <div class="table-responsive">
            <table class="table table-hover table-condensed">
                <thead>
                    <tr>
                        <th>Blueprint</th>
                        <th>Assignee</th>
                        <th>Importance</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($milestone->blueprints as $blueprint)
                        <tr>
                            <td><a href="{{URL::action('MilestoneController@getBlueprint', array($project->url, $milestone->url, $blueprint->blueprint_id))}}">{{$blueprint->title}}</a></td>
                            <td>
                                @if (isset($blueprint->user_assigned->name))
                                    {{$blueprint->user_assigned->name}}
                                @endif
                            </td>
                            <td>
                                <span style="color: {{Helper::getBlueprintImportanceColor($blueprint->importance)}}">
                                    {{Helper::getBlueprintImportance($blueprint->importance)}}
                                </span>
                            </td>
                            <td>
                                <span style="color: {{Helper::getBlueprintStatusColor($blueprint->status)}}">
                                    {{Helper::getBlueprintStatus($blueprint->status)}}
                                <span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
