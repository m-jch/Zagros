<!DOCTYPE html>
<html lang="{{Config::get('app.locale')}}">
    @include('layouts.guest.head')
    <body>
        <div class="container-fluid">
            <div id="header">
                <div class="row">
                    <div class="col-md-12">
                        <h1>
                            {{HTML::image('http://gravatar.com/avatar/'.md5(strtolower(trim(Auth::user()->email))).'?s=60', 'avatar', array('class' => 'avatar'))}}
                            <strong>{{Auth::user()->name}}</strong>
                        </h1>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="{{URL::to('/')}}">{{trans('layout.dashboard')}}</a></li>
                            @if (Auth::user()->admin)
                                <li>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{trans('layout.admin')}} <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{URL::action('AdminController@getCreateUser')}}">{{trans('layout.cnu')}}</a></li>
                                        <li><a href="{{URL::action('AdminController@getCreateProject')}}">{{trans('layout.cnp')}}</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">{{trans('layout.settings')}}</a></li>
                                    </ul>
                                </li>
                            @endif
                            <li>
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
