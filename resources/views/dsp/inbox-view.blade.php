@extends('layouts.master')

@section('title', 'Просмотр - Входящий ДСП')
@section('description', '')
@section('keywords', '')

@section('pageClass', 'main page')

@section('toolsbar')
    @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_dsp-inbox-view")))
        <a class='btn btn-danger' data-toggle='toolbar-tooltip' href='{{ URL::previous() }}' title='Закрыть'>
            <i class='fa fa-times'></i>
        </a>
    @endif
@stop

@section('nav_bar')
  @include('partials.navbar')
@stop

@section('content')

    <div id='wrapper' class="inbox-view">
    @include('partials.sidebar')
    @include('partials.tools')
    <!-- Content -->
        <div id='content'>
            @include('widgets.flash.flash_message')
            <div class='panel panel-default'>
                <div class='panel-heading'>
                    <i class='fa fa-pencil-square-o fa-lg'></i>
                    Входящий ДСП
                </div>
                <div class='panel-body'>

                    {!! Form::model($entity, ['id'=>'inbox_dsp_form'])!!}
                    {!! Form::hidden('id', $entity->id, ['id'=>'entity_id']) !!}
                    {!! Form::hidden('entity_type', get_class($entity), ['id'=>'entity_type']) !!}
                    {!! Form::hidden('dsp_num', $entity->dsp_num, ['id'=>'dsp_num']) !!}

                    <div class="row">
                        <div class="col-md-2">
                            @include('widgets.form._formitem_text', ['name' => 'entity_num', 'title' => 'Номер', 'placeholder' => 'Номер', 'readonly' => 'true'])
                        </div>
                        <div class="col-md-2">
                            @include('widgets.form._formitem_select', ['class'=>'selectpicker', 'disabled'=> 'true', 'name' => 'item_number', 'title' => 'Номенклатурный номер', 'options' => $item_numbers_opt])
                        </div>
                        <div class="col-md-3">
                            @include('widgets.form._formitem_text', ['name' => 'incoming_number', 'title' => 'Входящий номер', 'placeholder' => 'Входящий номер' , 'disabled' => 'true', 'readonly' => 'true'])
                        </div>
                        <div class="col-md-3">
                            {{-- @include('widgets.form._formitem_select', ['class'=>'selectpicker', 'disabled'=> 'true', 'name' => 'sender_id', 'title' => 'Отправитель', 'options' => $senders_opt]) --}}
                        </div>                        
                        <div class="col-md-2 text-right">
                            @include('widgets.form._formitem_checkbox', ['name'=>'status',
                                                                          'title'=> 'Статус',
                                                                          'value'=> '1',
                                                                          'id' => 'status',
                                                                          'class' => 'custom checkbox',
                                                                          'left' => null,
                                                                          'disabled' => 'true'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            @include('widgets.form._formitem_text', ['name' => 'title', 'title' => 'Тема', 'placeholder' => 'Тема документа', 'readonly' => 'true' ])
                        </div>
                        <div class="col-md-3">
                            @include('widgets.form._formitem_text', ['name' => 'create_date', 'value' => date('d.m.Y', strtotime($entity->create_date)), 'title' => 'Дата создания', 'placeholder' => '01.01.2016', 'describedby' => 'basic-addon1','disabled' => 'true', 'readonly' => 'true'])
                        </div>
                        <div class="col-md-3">
                            @include('widgets.form._formitem_text', ['name' => 'execute_date', 'value' => date('d.m.Y', strtotime($entity->execute_date)), 'title' => 'Дата исполнения', 'placeholder' => '01.01.2016', 'describedby' => 'basic-addon1', 'disabled' => 'true', 'readonly' => 'true'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @include('widgets.form._formitem_textarea', ['id' => 'description', 'name' => 'description', 'title' => 'Описание', 'rows' => '6', 'placeholder' => 'Описание ДСП', 'disabled' => 'true'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @include('widgets.form._formitem_textarea', ['name' => 'resolution', 'id' => 'resolution','title' => 'Резолюция', 'rows' => '3', 'placeholder' => 'Резолюция', 'disabled' => 'true'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @include('partials.responsibles')
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @include('partials.files_attachments', ['is_view' => true])
                        </div>
                    </div>
                    <div class="form-actions">
                        <a class="btn" href="{{ URL::previous() }}">Отмена</a>
                    </div>
                    {!! Form::close()!!}
                </div>
            </div>
            @include('partials.comments')
        </div>

    </div>
@stop

@section('custom_js')
    <script type="text/javascript">
        $(document).ready(function(){
           
        });
    </script>
@stop