<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    {{HTML::style('styles/bootstrap.min.css')}}
    {{HTML::style('styles/bootstrap-theme.min.css')}}
    {{HTML::style('styles/style.css')}}
    {{HTML::style('styles/'.Config::get('app.locale').'/fonts.css')}}
    {{HTML::style('styles/'.Config::get('app.locale').'/style.css')}}
    {{HTML::style('styles/magicsuggest-min.css')}}
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('head')
</head>
