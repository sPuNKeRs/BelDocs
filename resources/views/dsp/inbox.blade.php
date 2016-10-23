<?php
  use Illuminate\Support\Facades\Input;
?>
@extends('layouts.master')

@section('title', 'Входящие ДСП')
@section('description', '')
@section('keywords', '')

@section('pageClass', 'main page')

@section('toolsbar')
    @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_dsp-inbox-create")))
        <a class='btn' data-toggle='toolbar-tooltip' href='{{ route('dsp.inbox.create')}}' title='Создать ДСП'>
            <i class='fa fa-plus-circle'> Создать</i>
        </a>
    @endif
@stop

@include('partials.navbar')

@section('content')

    <div id='wrapper'>
    @include('partials.sidebar')
    @include('partials.tools')
    <!-- Content -->
        <div id='content'>
            @include('widgets.flash.flash_message')
            <div class="panel panel-default grid">
                <div class="panel-heading">
                    <i class='fa fa-wpforms fa-lg'></i>
                    Входящие ДСП
                    <div class="panel-tools">                        
                        <div class="badge">{{ $count }} записей</div>
                    </div>
                </div>
                <div class="wrapper-height">
                <table class="table">
                    <thead>
                    <tr>
                        <th>@sortLink('dsp_num', '#')</th>
                        <th>@sortLink('item_number_id', 'Номенк. номер')</th>
                        <th>@sortLink('incoming_number', 'Входящий номер')</th>
                        <th>@sortLink('title', 'Тема')</th>
                        <th>@sortLink('create_date', 'Создан')</th>
                        <th>@sortLink('execute_date', 'Исп. до')</th>
                        <th>@sortLink('status', 'Статус')</th>
                        <th class="actions">
                            Действия
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($inbox_dsps as $dsp)
                        <tr class="dsps {{ isset($dsp->status) ? 'success' : '' }} {{ ($dsp->draft == 1)?'draft' : ''}}">
                            <td>{{$dsp->entity_num}}</td>
                            <td>{{ (isset($dsp->item_number)) ? $dsp->item_number->item_number_dsp : '' }}</td>
                            <td>{{$dsp->incoming_number}}</td>
                            <td>{{$dsp->title}}</td>
                            <td>{{ date('d.m.Y', strtotime($dsp->create_date)) }}</td>
                            <td>{{ date('d.m.Y', strtotime($dsp->execute_date)) }}</td>
                            <td>{{ isset($dsp->status) ? 'Исполнен' : 'Не исполнен' }} </td>
                            <td class="action">
                            
                                @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_dsp-inbox-view")))
                                    <a class="btn btn-success dsps-inbox-view"
                                       href="{{ route('dsp.inbox.view', $dsp->id) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                @endif

                                @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_dsp-inbox-edit")))
                                    <a class="btn btn-info dsps-inbox-edit"
                                       href="{{ route('dsp.inbox.edit', $dsp->id) }}">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                @endif

                                @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_dsp-inbox-delete")))
                                    <a class="btn btn-danger delete dsps-inbox-delete"
                                       href="{{ route('dsp.inbox.delete', $dsp->id) }}">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                @endif

                                @if($dsp->draft == 1)
                                    <i class="fa fa-question-circle-o" title="Черновик"></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                </div>

                <div class="panel-footer" style="min-height: 54px;">

                    {{ $inbox_dsps->setPath('inbox')->appends(Input::except('page'))->render() }}
                    <div class="pull-right">
                        Показать с {{$slice}} по {{$perPage}} из {{$count}} записей
                    </div>
                </div>
            </div>
        </div>
        @stop
        @section('custom_js')
            <script>
                $(document).ready(function () {
                    $(".delete").click(function () {
                        return confirm("Вы действительно хотите удалить этот пункт?");
                    });

                    @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_dsp-inbox-edit")))
                    $('.dsps').dblclick(function (e) {
                        var href = $(e.currentTarget).find('a.dsps-inbox-edit').attr('href');
                        window.location = href;
                    });
                    @else
                    $('.dsps').dblclick(function (e) {
                        var href = $(e.currentTarget).find('a.dsps-inbox-view').attr('href');
                        window.location = href;
                    });
                    @endif
                });
            </script>
@stop
