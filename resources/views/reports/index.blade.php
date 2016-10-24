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
              <form>
              <fieldset>
                <legend>Параметры отчета</legend>
              </fieldset>
              <div class="form-actions">
                <button class="btn btn-default" type="submit">Сформировать</button>
                <button class="btn btn-default">Очистить</button>
              </div>
            </form>
          </div>
        </div>
        <!--Параметры отчета - конец-->

        <!--Результат-->

        <!--Стандартный отчет-->
        @include('reports.default-report')

        <!--Результат - конец-->
      </div>
    </div>
@stop
