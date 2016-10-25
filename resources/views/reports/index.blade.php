@extends('layouts.master')

@section('title', 'Отчеты')
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
        <!--Параметры отчета-->
        <div class='panel panel-default'>
          <div class='panel-heading'>
            <i class='fa fa-wpforms fa-lg'></i>
            Отчеты
          </div>
          <div class='panel-body'>
              {!! Form::open(['route' => 'reports.generate' , 'id'=>'report_param_form', 'name'=>'report_param_form'])!!}
              <fieldset>
                <legend>Параметры отчета</legend>
                <div class="row">
                  <div class="col-md-4">
                    @include('widgets.form._formitem_select', ['live_search' => true, 'data_size' => 5, 'class'=>'selectpicker', 'name' => 'entity_type_id', 'title' => 'Тип отчета', 'options' => $entity_type])
                  </div>
                  <div class="col-md-4">
                    @include('widgets.form._formitem_text', ['name' => 'from_date', 'title' => 'Дата начала периода', 'placeholder' => '01.01.2016', 'describedby' => 'basic-addon1', 'value' => date('d.m.Y') ])
                  </div>
                  <div class="col-md-4">
                    @include('widgets.form._formitem_text', ['name' => 'by_date', 'title' => 'Дата окончания периода', 'placeholder' => '01.01.2016', 'describedby' => 'basic-addon1', 'value' => date('d.m.Y') ])
                  </div>
                </div>

              </fieldset>
              <div class="form-actions">
                <button id="report-submit" class="btn btn-default" type="submit">Сформировать</button>

                <button id="clear-report" class="btn btn-default" >Очистить</button>
              </div>
            {!! Form::close()!!}
          </div>
        </div>
        <!--Параметры отчета - конец-->

        <!--Результат-->

        <!--Стандартный отчет-->

        <div id="report-result"></div>

        <!--Результат - конец-->
      </div>
    </div>
@stop

@section('custom_js')
    <script type="text/javascript">
        $(document).ready(function(){
          // Инициализация
          $('#from_date').datepicker();
          $('#by_date').datepicker();

          // ---- События ----

          // Формируем отчет
          $('#report-submit').on('click',function(e){
              console.log('---- report_param_form ----');
              reportGenerate();
              e.preventDefault();
          });

          // Очистить результат
          $('#clear-report').on('click', function(e){
            console.log('---- clear-report ----');
            $('#report-result').html('');
            e.preventDefault();
          });

          // ---- Функции ----

          // reportGenerate - begin
          function reportGenerate()
          {
            var token = $('input[name=_token]').val();
            var form = $('#report_param_form')[0];
            var formData = new FormData(form);

            $.ajax({
              url: '{{ route('reports.generate') }}',
              headers: {'X-CSRF-TOKEN': token},
              processData: false,
              contentType: false,
              data: formData,
              type: 'POST',
              success: function (response) {
                  console.log(response);
                  $('#report-result').html(response);
              },
              error: function(errors){
                  console.log(errors);
              }
            });
          }
          // reportGenerate - end
        });
    </script>
@stop
