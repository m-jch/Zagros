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
    
@stop
