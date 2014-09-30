<!DOCTYPE html>
<html lang="{{Config::get('app.locale')}}">
    @include('layouts.guest.head')
    <body>
        <div class="container-fluid">
            <div id="header">
                <div class="row">
                    <div class="col-md-12">
                        <h1>{{$project->name}}</h1>
                        <small>{{$project->description}}</small>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="@yield('projects-navbar')"><a href="{{URL::to('/')}}">{{trans('layout.projects')}}</a></li>
                            <li class="@yield('milestones-navbar')"><a href="{{URL::action('ProjectController@getIndex', $project->url)}}">{{trans('layout.milestones')}}</a></li>
                            <li class="@yield('milestone-navbar')"><a href="{{URL::action('MilestoneController@getIndex', array($project->url, $milestone->url))}}">{{$milestone->codename}}</a></li>
                            @if (Auth::user()->is_admin)
                                <li class="@yield('blueprint-navbar')"><a href="{{URL::action('MilestoneController@getCreateBlueprint', array($project->url, $milestone->url))}}">{{trans('layout.new_blueprint')}}</a></li>
                            @endif
                            @if (!Auth::user()->is_reader)
                                <li class="@yield('bug-navbar')"><a href="{{URL::action('MilestoneController@getCreateBug', array($project->url, $milestone->url))}}">{{trans('layout.new_bug')}}</a></li>
                            @endif
                            <li class="@yield('user-navbar')">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{trans('layout.user')}} <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">{{trans('layout.settings')}}</a></li>
                                    <li class="divider"></li>
                                    <li><a href="{{URL::action('UserController@getLogout')}}">{{trans('layout.logout')}}</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                        <hr>
                    </div>
                </div>
            </div>
            <div id="content">
                <div class="row">
                    @yield('content')
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3><a href="">{{trans('layout.zagros')}}</a><samll class="small"> {{ZA_VERSION}}</small></h3>
                        <ul class="list-inline">
                            <li><a href="">{{trans('layout.issue')}}</a></li>
                            <li><a href="">{{trans('layout.pull')}}</a></li>
                            <li><a href="">{{trans('layout.contact')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.guest.footer-includes')
    </body>
</html>
