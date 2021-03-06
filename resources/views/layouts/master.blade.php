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
    <link rel="stylesheet" href="{!! asset('bower_components/jquery-ui/themes/base/jquery-ui.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/hierapolis_theme_full.css') !!}">
    <link rel="stylesheet" href="{!! asset('bower_components/bootstrap-select/dist/css/bootstrap-select.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('bower_components/bootstrap-fileinput/css/fileinput.min.css') !!}">

    <link rel="stylesheet" href="{!! asset('css/custom.css') !!}">
    @yield('css_block')
  </head>
  <body class="@yield('pageClass')">
    @yield('nav_bar')
    <div class="container">
      @yield('content')
    </div>
    <!-- Footer -->
    <!-- Javascripts -->
    {{HTML::script('bower_components/jquery/dist/jquery.min.js')}}
    {{HTML::script('bower_components/moment/min/moment.min.js')}}
    {{HTML::script('bower_components/jquery-ui/jquery-ui.min.js')}}
    {{HTML::script('bower_components/jquery-ui/ui/i18n/datepicker-ru.js')}}

    {{HTML::script('bower_components/jquery-ui/ui/i18n/datepicker-ru.js')}}

    {{HTML::script('bower_components/bootstrap-select/dist/js/bootstrap-select.min.js')}}
    {{HTML::script('bower_components/bootstrap-select/dist/js/i18n/defaults-ru_RU.min.js')}}


    {{HTML::script('vendor/canvas-to-blob.min.js')}}
    {{HTML::script('vendor/Sortable.min.js')}}
    {{HTML::script('vendor/purify.min.js')}}


    {{HTML::script('bower_components/bootstrap-fileinput/js/fileinput.min.js')}}
    {{HTML::script('bower_components/bootstrap-fileinput/js/locales/ru.js')}}
    {{HTML::script('bower_components/bootstrap-fileinput/themes/fa/theme.js')}}


    {{HTML::script('bower_components/bootstrap/dist/js/bootstrap.min.js')}}




    {{HTML::script('vendor/jquery.knob.min.js')}}
    {{HTML::script('vendor/tinymce/tinymce.min.js')}}
    {{HTML::script('js/application.js')}}
    @yield('custom_js')
  </body>
</html>