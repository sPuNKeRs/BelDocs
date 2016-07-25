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
              {{--@include('errors.errmsg')--}}


            {!! Form::open(['route' => 'orders.inbox.create'])!!}
              <div class="row">
                  <div class="col-md-3">
                      @include('widgets.form._formitem_text', ['value' => $lastId+1,'name' => 'order_id', 'title' => 'Номер', 'placeholder' => 'Порядковый номер', 'readonly' => 'true'])
                  </div>
                  <div class="col-md-3">
                      @include('widgets.form._formitem_select', ['name' => 'item_number', 'title' => 'Номенклатурный номер', 'options' => $item_numbers_opt])
                  </div>
                  <div class="col-md-3">
                      @include('widgets.form._formitem_text', ['name' => 'incoming_number', 'title' => 'Входящий номер', 'placeholder' => 'Входящий номер' ])
                  </div>
                  <div class="col-md-3 text-right">
                      @include('widgets.form._formitem_checkbox', ['name'=>'status',
                                                                    'title'=> 'Статус',
                                                                    'value'=> '1',
                                                                    'id' => 'status',
                                                                    'class' => 'custom checkbox',
                                                                     'left' => null])
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-6">
                      @include('widgets.form._formitem_text', ['name' => 'title', 'title' => 'Тема', 'placeholder' => 'Тема приказа' ])
                  </div>
                  <div class="col-md-3">
                      @include('widgets.form._formitem_text', ['name' => 'create_date', 'title' => 'Дата создания', 'placeholder' => '01.01.2016', 'describedby' => 'basic-addon1', 'value' => date('d.m.Y') ])
                  </div>
                  <div class="col-md-3">
                      @include('widgets.form._formitem_text', ['name' => 'execute_date', 'title' => 'Дата исполнения', 'placeholder' => '01.01.2016', 'describedby' => 'basic-addon1', 'value' => date('d.m.Y') ])
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                      @include('widgets.form._formitem_textarea', ['name' => 'description', 'title' => 'Описание', 'rows' => '6', 'placeholder' => 'Описание приказа'])
                  </div>
              </div>
              <div class="form-actions">
                  @include('widgets.form._formitem_btn_submit',['title' => 'Сохранить', 'class' => 'btn btn-default'])
                  <a class="btn" href="{{ route('orders.inbox') }}">Отмена</a>
              </div>
              {{--{!! Form::token() !!}--}}
            {!! Form::close()!!}
          </div>
        </div>
      </div>
    </div>
@stop

@section('custom_js')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#create_date').datepicker();
            $('#execute_date').datepicker();
        });
    </script>
@stop