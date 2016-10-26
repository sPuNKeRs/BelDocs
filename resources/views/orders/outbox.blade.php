<?php

    use Illuminate\Support\Facades\Input;

?>

@extends('layouts.master')

@section('title', 'Исходящие приказы')
@section('description', '')
@section('keywords', '')

@section('pageClass', 'main page')

@section('toolsbar')
    @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_orders-outbox-create")))
        <a class='btn' data-toggle='toolbar-tooltip' href='{{ route('orders.outbox.create')}}' title='Создать приказ'>
            <i class='fa fa-plus-circle'> Создать</i>
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
            <div class="panel panel-default grid">
                <div class="panel-heading">
                    <i class='fa fa-wpforms fa-lg'></i>
                    Исходящие приказы
                    <div class="panel-tools">
                        <div class="btn-group">                            
                        </div>
                        <div class="badge">{{ $count }} записей</div>
                    </div>
                </div>
                <div class="wrapper-height">
                <table class="table">
                    <thead>
                    <tr>
                        <th>@sortLink('outbox_order_num', '#')</th>                        
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

                    @foreach($outbox_orders as $outbox_order)
                        <tr class="orders {{ isset($outbox_order->status) ? 'success' : '' }} {{ ($outbox_order->draft == 1)?'draft' : ''}}">
                            <td>{{$outbox_order->entity_num}}</td>                           
                            <td>{{$outbox_order->title}}</td>
                            <td>{{ date('d.m.Y', strtotime($outbox_order->create_date)) }}</td>
                            <td>{{ date('d.m.Y', strtotime($outbox_order->execute_date)) }}</td>
                            <td>{{ isset($outbox_order->status) ? 'Исполнен' : 'Не исполнен' }} </td>
                            <td class="action">
                                @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_orders-outbox-view")))
                                    <a class="btn btn-success orders-outbox-view"
                                       href="{{ route('orders.outbox.view', $outbox_order->id) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                @endif

                                @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_orders-outbox-edit")))
                                    <a class="btn btn-info orders-outbox-edit"
                                       href="{{ route('orders.outbox.edit', $outbox_order->id) }}">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                @endif

                                @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_orders-outbox-delete")))
                                    <a class="btn btn-danger delete orders-outbox-delete"
                                       href="{{ route('orders.outbox.delete', $outbox_order->id) }}">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                @endif

                                @if($outbox_order->draft == 1)
                                    <i class="fa fa-question-circle-o" title="Черновик"></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                </div>

                <div class="panel-footer" style="min-height: 54px;">

                    {{ $outbox_orders->setPath('outbox')->appends(Input::except('page'))->render() }}
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

                    @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_orders-outbox-edit")))
                    $('.orders').dblclick(function (e) {
                        var href = $(e.currentTarget).find('a.orders-outbox-edit').attr('href');
                        window.location = href;
                    });
                    @else
                    $('.orders').dblclick(function (e) {
                        var href = $(e.currentTarget).find('a.orders-outbox-view').attr('href');
                        window.location = href;
                    });
                    @endif
                });
            </script>
@stop
