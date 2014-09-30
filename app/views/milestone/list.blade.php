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
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Blueprint</th>
                    <th>Importance</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($milestone->blueprints as $blueprint)
                    <tr>
                        <td>{{$blueprint->title}}</td>
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
@stop
