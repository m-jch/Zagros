@extends('layouts.user.main')

@section('title')
    {{trans('layout.admin')}} - {{trans('layout.delete_user')}}
@stop

@section('admin-navbar')active @stop

@section('content')
    <div class="col-md-6 col-md-offset-3">
        <h2 class="text-center">{{trans('layout.delete_user')}}</h2>
        @if (Session::has('message'))
            <p class="text-info text-center">{{Session::get('message')}}</p>
        @endif
        {{Form::open(array('role' => 'form'))}}
            <br>
            <h4 class="text-center">{{trans('messages.delete_user', array('user_name' => $user->name))}}</h4>
            <br>
            <div class="form-group">
                {{Form::label('new_user', trans('messages.delete_user_change'))}}
                {{Form::select('new_user', $users, null, array('class' => 'form-control'))}}
                {{$errors->first('new_user', '<small class="text-warning">:message</small><br>')}}
            </div>
            <div class="form-group">
                <div class="col-sm-12 text-center">
                    {{Form::hidden('user_id', $user->user_id)}}
                    <a href="{{action('AdminController@getUsersList')}}" class="btn btn-primary">{{trans('layout.cancel')}}</a>
                    {{Form::submit(trans('layout.delete_user'), array('class' => 'btn btn-danger'))}}
                </div>
            </div>
        {{Form::close()}}
    </div>
@stop

@section('footer')
    <script>
        $(function() {
            var admins = $('#admins, #writers, #readers').magicSuggest({
                data: '{{URL::action('AdminController@postUsers')}}',
                valueField: 'user_id',
                displayField: 'name',
                mode: 'remote',
                allowFreeEntries: false,
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
