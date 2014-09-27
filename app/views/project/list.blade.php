@extends('layouts.user.main')

@section('title')
    {{trans('layout.zagros')}}::{{trans('layout.prjs')}}
@stop

@section('content')
    <div class="col-md-6 col-md-offset-0">
        <h2>Projects</h2>
        @if (Session::has('message'))
            <p class="text-info">{{Session::get('message')}}</p>
        @endif
        <table class="table table-hover  table-responsive">
            <thead>
                <tr>
                    <th>{{trans('layout.name')}}</th>
                    <th>{{trans('layout.created_at')}}</th>
                    @if (Auth::user()->admin)
                        <th>{{trans('layout.edit')}}</th>
                        <th>{{trans('layout.delete')}}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td><a href="">{{$project->name}}</a></td>
                        <td>{{(new Carbon\Carbon($project->created_at))->diffForHumans(Carbon\Carbon::now())}}</td>
                        <td><a href="{{URL::action('AdminController@getUpdateProject', $project->project_id)}}"><i class="fa fa-edit"></i></a></td>
                        <td><a href=""><i class="fa fa-remove"></i></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop
