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
          <div class="panel panel-default grid">
              <div class="panel-heading">
                  <i class='fa fa-wpforms fa-lg'></i>
                  Входящие приказы
                  <div class="panel-tools">
                      <div class="btn-group">
                          <a class="btn" href="#">
                              <i class="fa fa-wrench"></i>
                              Настройки
                          </a>
                          <a class="btn" href="#">
                              <i class="fa fa-filter"></i>
                              Фильтры
                          </a>
                          <a class="btn" data-toggle="toolbar-tooltip" href="#" title="" data-original-title="Обновить">
                              <i class="fa fa-refresh"></i>
                          </a>
                      </div>
                      <div class="badge">3 записи</div>
                  </div>
              </div>
              <table class="table">
                  <thead>
                  <tr>
                      <th>#</th>
                      <th>Номенклатурный номер</th>
                      <th>Входящий номер</th>
                      <th>Тема</th>
                      <th>Создан</th>
                      <th>Исполнить до</th>
                      <th>Статус</th>
                      <th class="actions">
                          Действия
                      </th>
                  </tr>
                  </thead>
                  <tbody>

                  @foreach($orders as $order)
                  <tr class="{{ isset($order->status) ? 'success' : '' }}  ">
                      <td>{{$order->id}}</td>
                      <td>{{$order->item_number}}</td>
                      <td>{{$order->incoming_number}}</td>
                      <td>{{$order->title}}</td>
                      <td>{{ date('d-m-Y', strtotime($order->create_date)) }}</td>
                      <td>{{ date('d-m-Y', strtotime($order->execute_date)) }}</td>
                      <td>{{ isset($order->status) ? 'Исполнен' : 'Не исполнен' }} </td>
                      <td class="action">
                          <a class="btn btn-success" data-toggle="tooltip" href="#" title="">
                              <i class="fa fa-search-plus"></i>
                          </a>
                          <a class="btn btn-info" href="#">
                              <i class="fa fa-pencil-square-o"></i>
                          </a>
                          <a class="btn btn-danger" href="#">
                              <i class="fa fa-trash-o"></i>
                          </a>
                      </td>
                  </tr>
                  @endforeach

                  </tbody>
              </table>
              <div class="panel-footer">
                  <ul class="pagination pagination-sm">
                      <li>
                          <a href="#">«</a>
                      </li>
                      <li class="active">
                          <a href="#">1</a>
                      </li>
                      <li>
                          <a href="#">2</a>
                      </li>
                      <li>
                          <a href="#">3</a>
                      </li>
                      <li>
                          <a href="#">»</a>
                      </li>
                  </ul>
                  <div class="pull-right">
                      Показать с 1 по 10 из 32 записей
                  </div>
              </div>
          </div>
    </div>
@stop
