@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
Панель администрирования
@stop

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
      <h3><i class="fa fa-dashboard"></i> Панель управления</h3>
      <hr/>
  </div>
  <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="stats-item margin-left-5 margin-bottom-12">
          <a href="/" style="color: white;"><i class="fa fa-home icon-large"></i><span class="text-large margin-left-15"></span><br/>На главную</a></div>
          <div class="stats-item margin-left-5 margin-bottom-12"><i class="fa fa-user icon-large"></i> <span class="text-large margin-left-15">{!! $registered !!}</span>
          <br/>Всего пользователей</div>
          <div class="stats-item margin-left-5 margin-bottom-12"><i class="fa fa-unlock-alt icon-large"></i> <span class="text-large margin-left-15">{!! $active !!}</span>
              <br/>Активных пользователей</div>
          <div class="stats-item margin-left-5 margin-bottom-12"><i class="fa fa-lock icon-large"></i> <span class="text-large margin-left-15">{!! $pending !!}</span>
              <br/>В ожидании</div>
          <div class="stats-item margin-left-5 margin-bottom-12"><i class="fa fa-ban icon-large"></i> <span class="text-large margin-left-15">{!! $banned !!}</span>
              <br/>Забанненых</div>
  </div>
</div>
@stop