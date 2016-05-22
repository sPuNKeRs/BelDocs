@extends('layouts.master')

@section('title', 'Приказы')
@section('description', '')
@section('keywords', '')

@section('pageClass', '')

@section('content')
  @include('partials.navbar')
    <div id='wrapper'>
      @include('partials.sidebar')
      @include('partials.tools')
      <!-- Content -->
      <div id='content'>
        <div class='panel panel-default'>
          <div class='panel-heading'>
            <i class='fa fa-wpforms fa-lg'></i>
            Приказы          
          </div>
          <div class='panel-body'>            
          </div>
        </div>
      </div>
    </div>
@stop

