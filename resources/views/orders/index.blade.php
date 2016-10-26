@extends('layouts.master')
@section('title', 'Приказы')
@section('description', '')
@section('keywords', '')
@section('pageClass', 'main page')
@section('nav_bar')
  @include('partials.navbar')
@stop
@section('content')
<div id='wrapper'>
  @include('partials.sidebar')
  @include('partials.tools')
  <!-- Content -->
  <div id='content' class='orders-dashbord'>
    <div class="row">
      <div class="col-md-6">
        <div class='panel panel-default'>
          <div class='panel-heading'>
            <i class='fa fa-wpforms fa-lg'></i>
            Входящие приказы
            <div class="panel-tools">
              <div class="badge">{{ count($inbox_orders) }} Всего</div>
              <div class="badge">0 Просрочено</div>
              <div class="badge">0 Выполняются</div>
            </div>
          </div>          
          <div class="wrapper-height">
            <table class="table inbox-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Тема</th>
                  <th>Исп. до</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>

              @foreach($inbox_orders as $inbox)
                <tr>
                  <td>{{ $inbox->entity_num }}</td>
                  <td>{{ $inbox->title }}</td>
                  <td>{{ date('d.m.Y', strtotime($inbox->execute_date)) }}</td>
                  <td class="action">
                      @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_orders-inbox-view")))
                          <a class="btn btn-success orders-inbox-view"
                             href="{{ route('orders.inbox.view', $inbox->id) }}">
                              <i class="fa fa-eye"></i>
                          </a>
                      @endif

                      @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_orders-inbox-edit")))
                          <a class="btn btn-info orders-inbox-edit"
                             href="{{ route('orders.inbox.edit', $inbox->id) }}">
                              <i class="fa fa-pencil-square-o"></i>
                          </a>
                      @endif
                    </td>
                </tr>
              @endforeach

            </tbody>
          </table>
        </div>
        <div class="panel-footer" style="min-height: 54px;"></div>
      </div>
    </div>
    <div class="col-md-6">
      <div class='panel panel-default'>
        <div class='panel-heading'>
          <i class='fa fa-wpforms fa-lg'></i>
          Исходящие приказы
          <div class="panel-tools">
            <div class="badge">{{ count($outbox_orders) }} Всего</div>              
            <div class="badge">0 Просрочено</div>
            <div class="badge">0 Выполняются</div>
          </div>
        </div>
        <div class='wrapper-height'>
          <table class="table outbox-table">
            <thead>
              <tr>
                <th>#</th>
                <th>Тема</th>
                <th>Исп. до</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              
              @foreach($outbox_orders as $outbox)
                <tr>
                  <td>{{ $outbox->entity_num }}</td>
                  <td>{{ $outbox->title }}</td>
                  <td>{{ date('d.m.Y', strtotime($outbox->execute_date)) }}</td>
                  <td class="action">
                    @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_orders-outbox-view")))
                        <a class="btn btn-success orders-outbox-view"
                           href="{{ route('orders.outbox.view', $outbox->id) }}">
                            <i class="fa fa-eye"></i>
                        </a>
                    @endif

                    @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_orders-outbox-edit")))
                        <a class="btn btn-info orders-outbox-edit"
                           href="{{ route('orders.outbox.edit', $outbox->id) }}">
                            <i class="fa fa-pencil-square-o"></i>
                        </a>
                    @endif
                    </td>
                </tr>
              @endforeach  

          </tbody>
        </table>
      </div>
      <div class="panel-footer" style="min-height: 54px;"></div>
    </div>
  </div>
</div>
</div>
</div>
@stop
@section('custom_js')
  <script>
    $(document).ready(function(){





    })
  </script>
@stop
