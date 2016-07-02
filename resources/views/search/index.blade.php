@extends('layouts.master')

@section('title', 'Поиск')
@section('description', '')
@section('keywords', '')

@section('pageClass', 'main page')
@include('partials.navbar')  
@section('content')
    
    <div id='wrapper'>
      @include('partials.sidebar')
      @include('partials.tools')
      <!-- Content -->
      <div id='content'>
        <div class='panel panel-default'>
          <div class='panel-heading'>
            <i class='fa fa-wpforms fa-lg'></i>
            Поиск          
          </div>
          <div class='panel-body'>            
          </div>
        </div>
      </div>
    </div>
@stop

