@extends('layouts.master')

@section('title', 'Входящие приказы')
@section('description', '')
@section('keywords', '')

@section('pageClass', 'main page')

@section('toolsbar')    
    <a class='btn' data-toggle='toolbar-tooltip' href='{{ route('orders.inbox.create')}}' title='Создать приказ'>
      <i class='fa fa-plus-circle'></i>
      
    </a>
@stop

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
            Входящие приказы          
          </div>
          <div class='panel-body'>            
          </div>
        </div>
      </div>
    </div>
@stop

