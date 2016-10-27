@extends('layouts.master')

@section('title', 'Поиск')
@section('description', '')
@section('keywords', '')
@section('css_block')
  <style type="text/css">
    #search-result .search-item{
      padding: 10px;
    }

    .search-item {
      max-width: 850px;
      border-top: 1px solid green;
      border-bottom: 1px solid green;
      margin: 10px;
    }
  </style>
@stop

@section('pageClass', 'main page')
@section('nav_bar')
  @include('partials.navbar')
@stop
@section('content')

    <div id='wrapper'>
      @include('partials.sidebar')
      @include('partials.tools')
      <!-- Content -->
      <div id='content'>
        <!--Строка поиска - начало-->
        <div class='panel panel-default'>
          <div class='panel-heading'>
            <i class='fa fa-wpforms fa-lg'></i>
            Поиск
          </div>
          <div class='panel-body'>
          {!! Form::open(['route' => 'search.go' , 'id'=>'search_form', 'name'=>'search_form'])!!}
              <fieldset>
                <legend>Строка поиска</legend>
                <div class="row">
                  <div class="col-md-9">
                    @include('widgets.form._formitem_text', ['name' => 'search_query', 'title' => '', 'placeholder' => 'Введите текст для поиска'])
                  </div>
                  <div class="col-md-3">
                    <button id="search-btn" class="btn btn-success" >Найти</button>
                    <button id="clear-search" class="btn btn-danger" >Очистить</button>
                  </div>
                </div>
              </fieldset>
            {!! Form::close()!!}
          </div>
        </div>
        <!--Строка поиска - конец-->

        <!-- Результат поиска - начало-->
        <div id="search-result"></div>
        <!-- Результат поиска - конец-->
      </div>
    </div>
@stop

@section('custom_js')
    <script type="text/javascript">
      $(document).ready(function(){
        // Инциализация
        var timer;

        // События

        // Начать поиск - кнопка
        $('#search-btn').on('click', function(e){
          search();

          e.preventDefault();
        });

        // Начинать поиск при наборе в строке
        // Если в строке от 3 символов
        $('#search_query').on('keyup', function(e){
          window.clearTimeout(timer);
          if ($('#search_query').val().length >= 3) {
            timer = setTimeout(function(){
                search();
            }, 1500);
          }
        });

        // Очистить результат поиска
        $('#clear-search').on('click', function(e){
          $('#search-result').html('');

          e.preventDefault();
        });
        // Функции

        // Функция оптравки формы поиска - начало
        function search()
        {
          var token = $('input[name=_token]').val();
          var form = $('#search_form')[0];
          var formData = new FormData(form);

          $.ajax({
            url: '{{ route('search.go') }}',
            headers: {'X-CSRF-TOKEN': token},
            processData: false,
            contentType: false,
            data: formData,
            type: 'POST',
            success: function (response) {
                $('#search-result').html('');
                console.log(response);
                $('#search-result').html(response);
            },
            error: function(errors){
                setErrors(errors);
                console.log(errors);
            }
          });
        }
          // Функция оптравки формы поиска - конец

          // Вывод ошибок - начало
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
          // Вывод ошибок - конец

          // При изменнении значния в поле
          // убирать класс ошибки
          $('input').bind('keypress change',function(e){
              var self = e.currentTarget;
              $(self).parent('div').removeClass('has-error');
              $(self).parent('div').find('.help-block').remove();
          });

      });
    </script>
@stop

