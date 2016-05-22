<!DOCTYPE html>
<html class='no-js' lang='ru'>
  <head>
    <meta charset='utf-8'>
    <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
    <title>@yield('title')</title>
    <meta content='PuNKeR' name='author'>    
    <meta content='@yield('description')' name='description'>
    <meta content='@yield('keywords')' name='keywords'>   
    <link rel="stylesheet" href="{!! asset('bower_components/font-awesome/css/font-awesome.min.css') !!}">    
    <link rel="stylesheet" href="{!! asset('css/hierapolis_theme_full.css') !!}">    
    <link rel="stylesheet" href="{!! asset('css/custom.css') !!}">      
  </head>
  <body class="@yield('pageClass')">
    <div class="container">
      @yield('content')      
    </div>    

    <!-- Footer -->
    <!-- Javascripts -->
    <script src="{!! asset('bower_components/jquery/dist/jquery.min.js') !!}" type="text/javasript"></script>
    <script src="{!! asset('bower_components/jquery-ui/jquery-ui.min.js') !!}" type="text/javasript"></script>
    <script src="{!! asset('vendor/modernizr.js') !!}" type="text/javasript"></script>
    <script src="{!! asset('bower_components/bootstrap/dist/js/bootstrap.min.js') !!}" type="text/javasript"></script>    
  </body>
</html>