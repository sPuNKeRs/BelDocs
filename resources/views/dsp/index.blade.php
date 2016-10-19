@extends('layouts.master')
@section('title', 'ДСП')
@section('description', '')
@section('keywords', '')
@section('pageClass', 'main page')
@include('partials.navbar')
@section('content')
<div id='wrapper'>
  @include('partials.sidebar')
  @include('partials.tools')
  <!-- Content -->
  <div id='content' class='dsps-dashbord'>
    <div class="row">
      <div class="col-md-6">
        <div class='panel panel-default'>
          <div class='panel-heading'>
            <i class='fa fa-wpforms fa-lg'></i>
            Входящие ДСП
            <div class="panel-tools">
              <div class="badge">{{ count($inbox_dsps) }} Всего</div>
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

              @foreach($inbox_dsps as $inbox)
                <tr>
                  <td>{{ $inbox->dsp_num }}</td>
                  <td>{{ $inbox->title }}</td>
                  <td>{{ date('d.m.Y', strtotime($inbox->execute_date)) }}</td>
                  <td class="action">
                      @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_dsp-inbox-view")))
                          <a class="btn btn-success dsps-inbox-view"
                             href="{{ route('dsp.inbox.view', $inbox->id) }}">
                              <i class="fa fa-eye"></i>
                          </a>
                      @endif

                      @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_dsp-inbox-edit")))
                          <a class="btn btn-info dsps-inbox-edit"
                             href="{{ route('dsp.inbox.edit', $inbox->id) }}">
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
          Исходящие ДСП
          <div class="panel-tools">
            <div class="badge">{{ count($outbox_dsps) }} Всего</div>              
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
              
              @foreach($outbox_dsps as $outbox)
                <tr>
                  <td>{{ $outbox->dsp_num }}</td>
                  <td>{{ $outbox->title }}</td>
                  <td>{{ date('d.m.Y', strtotime($outbox->execute_date)) }}</td>
                  <td class="action">
                    @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_dsp-outbox-view")))
                        <a class="btn btn-success dsps-outbox-view"
                           href="{{ route('dsp.outbox.view', $outbox->id) }}">
                            <i class="fa fa-eye"></i>
                        </a>
                    @endif

                    @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_dsp-outbox-edit")))
                        <a class="btn btn-info dsps-outbox-edit"
                           href="{{ route('dsp.outbox.edit', $outbox->id) }}">
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
