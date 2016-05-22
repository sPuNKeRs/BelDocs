<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">


    <link rel="stylesheet" href="{!! asset('css/hierapolis_theme_full.css') !!}">  
    <link rel="stylesheet" href="{!! asset('bower_components/font-awesome/css/font-awesome.min.css') !!}">    
    {!! HTML::style('packages/jacopo/laravel-authentication-acl/css/style.css') !!}
    {!! HTML::style('packages/jacopo/laravel-authentication-acl/css/baselayout.css') !!}
    {!! HTML::style('packages/jacopo/laravel-authentication-acl/css/fonts.css') !!}   
    
    <link rel="stylesheet" href="{!! asset('css/custom.css') !!}">  
     
    

    @yield('head_css')
    {{-- End head css --}}

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

    <body class="@yield('pageClass')">
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>