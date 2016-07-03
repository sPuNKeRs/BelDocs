@extends('layouts.master')

@section('title', 'Создание - Входящий приказ')
@section('description', '')
@section('keywords', '')

@section('pageClass', 'main page')

@section('toolsbar')    
    
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
            <i class='fa fa-pencil-square-o fa-lg'></i>
            Форма создание входящего приказа
          </div>
          <div class='panel-body'>   
            {!! Form::open()!!}
              @include('widgets.form._formitem_text', ['name' => 'email', 'title' => 'Email', 'placeholder' => 'Ваш Email' ])
              @include('widgets.form._formitem_btn_submit', ['title' => 'Создать'])
              @include('widgets.form._formitem_password', ['name' => 'password', 'title' => 'Пароль', 'placeholder' => 'Ваш пароль'])
              @include('widgets.form._formitem_textarea', ['name' => 'description', 'title' => 'Описание', 'row' => 4])
              @include('widgets.form._formitem_text_with_help', ['name' => 'input_help', 'title' => 'Поле с помощью', 'placeholder' => 'Тут ваш текст', 'help' => 'Тект подсказки'])
              @include('widgets.form._formitem_tooltip_text_field', ['name' => 'tooltip_inp', 'title' => 'Всплывающая подсказка', 'tooltip' => 'Это подсказка', 'placeholder' => 'Тут ваш текст' ])
            {!! Form::close()!!}
          </div>
        </div>
      </div>
    </div>
@stop

