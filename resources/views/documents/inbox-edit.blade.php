@extends('layouts.master')

@section('title', 'Редактирование - Входящий документ')
@section('description', '')
@section('keywords', '')

@section('pageClass', 'main page')

@section('toolsbar')
    @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_documents-inbox-create")))
        <a class='btn save_inbox_document' data-toggle='toolbar-tooltip' href='#' title='Сохранить'>
            <i class='fa fa-plus-circle'> Сохранить</i>
        </a>
        &nbsp;
        <a class='btn btn-danger' data-toggle='toolbar-tooltip' href='{{ URL::previous() }}' title='Закрыть'>
            <i class='fa fa-times'></i>
        </a>
    @endif
@stop

@section('nav_bar')
  @include('partials.navbar')
@stop

@section('content')

    <div id='wrapper'>
    @include('partials.sidebar')
    @include('partials.tools')
    <!-- Content -->
        <div id='content'>
            @include('widgets.flash.flash_message')
            <div class='panel panel-default'>
                <div class='panel-heading'>
                    <i class='fa fa-pencil-square-o fa-lg'></i>
                    Форма редактирования входящего приказа
                    <div id="stateInfo" class="pull-right"></div>
                </div>
                <div class='panel-body'>

                    {!! Form::model($entity, ['route' => ['documents.inbox.save', $entity->id], 'id'=>'inbox_document_form'])!!}
                    {!! Form::hidden('id', $entity->id, ['id'=>'entity_id']) !!}
                    {!! Form::hidden('entity_type', get_class($entity), ['id'=>'entity_type']) !!}
                    {!! Form::hidden('doc_num', $entity->doc_num, ['id'=>'doc_num']) !!}

                    <div class="row">
                        <div class="col-md-2">
                            @include('widgets.form._formitem_text', ['name' => 'entity_num', 'title' => 'Номер', 'placeholder' => 'Номер'])
                        </div>
                        <div class="col-md-2">
                            @include('widgets.form._formitem_select', ['class'=>'selectpicker', 'name' => 'item_number_id', 'title' => 'Номенклатурный номер', 'options' => $item_numbers_opt])
                        </div>
                        <div class="col-md-3">
                            @include('widgets.form._formitem_select', ['class'=>'selectpicker', 'name' => 'sender_id', 'title' => 'Отправитель', 'options' => $senders_opt])
                        </div>
                        <div class="col-md-3">
                            @include('widgets.form._formitem_text', ['name' => 'incoming_number', 'title' => 'Входящий номер', 'placeholder' => 'Входящий номер' ])
                        </div>                                            
                        <div class="col-md-2 text-right">
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
                            @include('widgets.form._formitem_text', ['name' => 'title', 'title' => 'Тема', 'placeholder' => 'Тема документа' ])
                        </div>
                        <div class="col-md-3">
                            @include('widgets.form._formitem_text', ['name' => 'create_date', 'value' => date('d.m.Y', strtotime($entity->create_date)), 'title' => 'Дата создания', 'placeholder' => '01.01.2016', 'describedby' => 'basic-addon1'])
                        </div>
                        <div class="col-md-3">
                            @include('widgets.form._formitem_text', ['name' => 'execute_date', 'value' => date('d.m.Y', strtotime($entity->execute_date)), 'title' => 'Дата исполнения', 'placeholder' => '01.01.2016', 'describedby' => 'basic-addon1'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @include('widgets.form._formitem_textarea', ['id' => 'description', 'name' => 'description', 'title' => 'Описание', 'rows' => '6', 'placeholder' => 'Описание документа'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @include('widgets.form._formitem_textarea', ['name' => 'resolution', 'id' => 'resolution','title' => 'Резолюция', 'rows' => '3', 'placeholder' => 'Резолюция'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @include('partials.responsibles')
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @include('partials.files_attachments')
                        </div>
                    </div>
                    <div class="form-actions">
                        @if(App::make('authentication_helper')->hasPermission(array("_superadmin")) || App::make('authenticator')->getLoggedUser()->id == $entity->author_id)
                            <button id="save_inbox_document" class="btn btn-default save_inbox_document">Сохранить</button>
                            <button id="save_close_inbox_document" class="btn btn-default save_close_inbox_document">Сохранить и закрыть</button>
                        @endif

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
            // Сохранить приказ
            $('.save_inbox_document').on('click',function(e){
                saveInboxDocument();
                e.preventDefault();
            });

            // Сохранить и закрыть приказ
            $('.save_close_inbox_document').click(function(e){
                saveInboxDocument(true);

                e.preventDefault();
            });

            // Функция отправки формы приказа
            function saveInboxDocument(close)
            {
                tinyMCE.triggerSave(true,true);
                
                setStateInfo('save');
                $('#draft').val('');
                var token = $('input[name=_token]').val();
                var form = $('#inbox_document_form')[0];
                var formData = new FormData(form);

                $.ajax({
                    url: '{{ route('documents.inbox.save') }}',
                    headers: {'X-CSRF-TOKEN': token},
                    processData: false,
                    contentType: false,
                    data: formData,
                    type: 'POST',
                    success: function (response) {
                        setStateInfo('saved');

                        if(response.id){
                            console.log(response.id);
                            $('#entity_id').val(response.id);
                        }

                        if(close){
                            if(confirm('Закрыть приказ?')){
                                location.href = document.referrer;
                            }
                        };
                        console.log(response);
                    },
                    error: function(errors){
                        setStateInfo('error');
                        setErrors(errors);
                    }
                });
            }
            // Пометить ошибки
            function setErrors(errors){
                console.log(errors);
                var err = JSON.parse(errors.responseText);

                $.each(err, function(index, value) {
                    var errMsg = '<p class="help-block">'+value+'</p>';
                    $("#"+index+"").parent('div').addClass('has-error');
                    $("#"+index+"").parent('div').find('.help-block').remove();
                    $("#"+index+"").parent('div').append(errMsg);
                });
            }

            // Состояние сохранения
            function setStateInfo(state)
            {
                var msg;

                switch (state){
                    case 'save':
                        msg = "<i class='fa fa-floppy-o fa-fw fa-lg'></i> Сохранение...";
                        break;

                    case 'saved':
                        msg = "<i style='color: rgb(86, 190, 255)' class='fa fa-floppy-o fa-lg'></i> Сохранено";
                        break;

                    case 'load':
                        msg = "<i class='fa fa-spinner fa-lg'></i> Загрузка...";
                        break;

                    case 'error':
                        msg = "<i style='color: red;' class='fa fa-exclamation-circle fa-lg'></i> Ошибка при сохранении";
                        break;
                    case 'draft':
                        msg = "<i class='fa fa-newspaper-o fa-lg'></i> Создан черновик";
                        break;
                }

                $('#stateInfo').html(msg);
            }


            isDraft();
            // Проверка на черновик
            function isDraft()
            {
                if($('#draft').val() == '1'){
                    setStateInfo('draft');
                }
            }

            // При изменнении значния в поле
            // убирать класс ошибки
            $('input').bind('keypress change',function(e){
                var self = e.currentTarget;
                $(self).parent('div').removeClass('has-error');
                $(self).parent('div').find('.help-block').remove();
            });

            $('#create_date').datepicker();
            $('#execute_date').datepicker();
        });
    </script>
@stop