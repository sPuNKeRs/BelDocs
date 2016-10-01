@extends('layouts.master')
@section('title', 'Приказы')
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
    <div class="row">
      <div class="col-md-6">
        <div class='panel panel-default'>
          <div class='panel-heading'>
            <i class='fa fa-wpforms fa-lg'></i>
            Входящие приказы
            <div class="panel-tools">
              <div class="badge">0 Всего</div>
              <div class="badge">0 Выполнено</div>
              <div class="badge">0 Просрочено</div>
              <div class="badge">0 Выполняются</div>
            </div>
          </div>
          <div class='panel-body'>
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Тема</th>
                  <th>Исполнить до</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Приказ 1</td>
                  <td>10-12-2016</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Приказ 2</td>
                  <td>02-12-2016</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Приказ 3</td>
                  <td>13-12-2016</td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>Приказ 4</td>
                  <td>16-12-2016</td>
                </tr>
              <tr></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class='panel panel-default'>
        <div class='panel-heading'>
          <i class='fa fa-wpforms fa-lg'></i>
          Исходящие приказы
          <div class="panel-tools">
            <div class="badge">0 Всего</div>
            <div class="badge">0 Выполнено</div>
            <div class="badge">0 Просрочено</div>
            <div class="badge">0 Выполняются</div>
          </div>
        </div>
        <div class='panel-body'>
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Тема</th>
                <th>Исполнить до</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Приказ 1</td>
                <td>10-12-2016</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Приказ 2</td>
                <td>02-12-2016</td>
              </tr>
              <tr>
                <td>3</td>
                <td>Приказ 3</td>
                <td>13-12-2016</td>
              </tr>
              <tr>
                <td>4</td>
                <td>Приказ 4</td>
                <td>16-12-2016</td>
              </tr>
            <tr></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
</div>
@stop