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
        <div id="message"></div>
        <div class='panel panel-default'>
          <div class='panel-heading'>
            <i class='fa fa-pencil-square-o fa-lg'></i>
            Форма создание входящего приказа
              <div id="stateInfo" class="pull-right"></div>
          </div>

          <div class='panel-body'>
              {{--@include('errors.errmsg')--}}


            {!! Form::open(['route' => 'orders.inbox.create' , 'files'=> 'true', 'id'=>'order_form', 'name'=>'order_form'])!!}
              {!! Form::hidden('order_id', $order_id, ['id'=>'order_id']) !!}
              @if($draft)
                  {!! Form::hidden('draft', $draft, ['id'=>'draft']) !!}
              @endif

              <div class="row">
                  <div class="col-md-3">
                      @include('widgets.form._formitem_text', ['value' => $last_order_num+1,'name' => 'order_num', 'title' => 'Номер', 'placeholder' => 'Порядковый номер', 'readonly' => 'true'])
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
                      @include('widgets.form._formitem_textarea', ['name' => 'description', 'value'=>'' , 'id' => 'description','title' => 'Описание', 'rows' => '6', 'placeholder' => 'Описание приказа'])
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                      @include('partials.files_attachments')
                  </div>
              </div>
              <div class="form-actions">
                  {{--@include('widgets.form._formitem_btn_submit',['title' => 'Сохранить', 'class' => 'btn btn-default'])--}}
                  <button id="save_order" class="btn btn-default">Сохранить</button>
                  <button id="save_close_order" class="btn btn-default">Сохранить и закрыть</button>
                  <a id='cancelBtn' class="btn" href="{{ route('orders.inbox') }}">Отмена</a>
              </div>
              {{--{!! Form::token() !!}--}}
            {!! Form::close()!!}

        </div>
      </div>

    </div>
@stop

@section('custom_js')
    <script type="text/javascript">
        $(document).ready(function(){
            // Сохранить приказ
            $('#save_order').on('click',function(e){
                saveOrder();
                e.preventDefault();
            });

            // Сохранить и закрыть приказ
            $('#save_close_order').click(function(e){
                saveOrder(true);

                e.preventDefault();
            });

            // Функция отправки формы приказа
            function saveOrder(close)
            {
                setStateInfo('save');
                $('#draft').val('');
                var token = $('input[name=_token]').val();
                var form = $('#order_form')[0];
                var formData = new FormData(form);


                //console.log($('#description').val());

                // Display the key/value pairs
                // for (var pair of formData.entries()) {
                //       console.log(pair[0]+ ', ' + pair[1]);
                // }

                $.ajax({
                    url: '{{ route('orders.inbox.create') }}',
                    headers: {'X-CSRF-TOKEN': token},
                    processData: false,
                    contentType: false,
                    data: formData,
                    type: 'POST',
                    success: function (response) {
                        setStateInfo('saved');

                        if(response.order_id){
                            $('#order_id').val(response.order_id);
                        }

                        if(close){
                           // console.log('close');
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
        });

        // Пометить ошибки
        function setErrors(errors){

            //$('#message').html(@include('widgets.form._alerts_message'));

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
    </script>
@stop