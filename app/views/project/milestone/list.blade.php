@extends('layouts.project.main')

@section('title')
    {{trans('layout.zagros')}}::{{trans('layout.milestones')}}
@stop

@section('content')
    <div class="col-md-6 col-md-offset-3">
        <h2 class="text-center">{{trans('layout.milestones')}}</h2>
        @if (Session::has('message'))
            <p class="text-info text-center">{{Session::get('message')}}</p>
        @endif
        @forelse ($project->milestones as $milestone)
            <div>
                <h4>
                    <a href="">{{$milestone->codename}}</a>
                    @if (Auth::user()->is_admin)
                        <small class="pull-right"> <a href="{{URL::action('ProjectController@getEdit', $project->url, $milestone->milestone_id)}}/{{$milestone->milestone_id}}">Edit</a></small>
                    @endif
                </h4>
                <small>{{$milestone->description}}</small>
                <hr>
            </div>
        @empty
            <h4 class="text-info text-center">{{trans('messages.no_milestone')}}</h4>
        @endforelse
    </div>
@stop
