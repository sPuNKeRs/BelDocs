<?php

if (Request::has('page')) {
    $page = Request::input('page');
}else{
    $page = null;
}


?>

@extends('layouts.master')

@section('title', 'Входящие приказы')
@section('description', '')
@section('keywords', '')

@section('pageClass', 'main page')

@section('toolsbar')
    @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_orders-inbox-create")))
        <a class='btn' data-toggle='toolbar-tooltip' href='{{ route('orders.inbox.create')}}' title='Создать приказ'>
            <i class='fa fa-plus-circle'></i>
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
                    Входящие приказы
                    <div class="panel-tools">
                        <div class="btn-group">
                            {{--<a class="btn" href="#">--}}
                            {{--<i class="fa fa-wrench"></i>--}}
                            {{--Настройки--}}
                            {{--</a>--}}
                            {{--<a class="btn" href="#">--}}
                            {{--<i class="fa fa-filter"></i>--}}
                            {{--Фильтры--}}
                            {{--</a>--}}
                            {{--<a class="btn" data-toggle="toolbar-tooltip" href="#" title="" data-original-title="Обновить">--}}
                            {{--<i class="fa fa-refresh"></i>--}}
                            {{--</a>--}}
                        </div>
                        <div class="badge">{{ $count }} записей</div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>@sortLink('order_num', '#', {!! $page !!})</th>
                        <th>@sortablelink('item_number', 'Номенклатурный номер')</th>
                        <th>@sortablelink('incoming_number', 'Входящий номер')</th>
                        <th>@sortablelink('title', 'Тема')</th>
                        <th>@sortablelink('create_date', 'Создан')</th>
                        <th>@sortablelink('execute_date', 'Исполнить до')</th>
                        <th>@sortablelink('status', 'Статус')</th>
                        <th class="actions">
                            Действия
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($orders as $order)
                        <tr class="orders {{ isset($order->status) ? 'success' : '' }}  ">
                            <td>{{$order->order_num}}</td>
                            <td>{{$order->item_number}}</td>
                            <td>{{$order->incoming_number}}</td>
                            <td>{{$order->title}}</td>
                            <td>{{ date('d.m.Y', strtotime($order->create_date)) }}</td>
                            <td>{{ date('d.m.Y', strtotime($order->execute_date)) }}</td>
                            <td>{{ isset($order->status) ? 'Исполнен' : 'Не исполнен' }} </td>
                            <td class="action">
                                {{--<a class="btn btn-success" data-toggle="tooltip" href="#" title="">--}}
                                {{--<i class="fa fa-search-plus"></i>--}}
                                {{--</a>--}}

                                @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_orders-inbox-view")))
                                    <a class="btn btn-success orders-inbox-view"
                                       href="{{ route('orders.inbox.view', $order->id) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                @endif

                                @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_orders-inbox-edit")))
                                    <a class="btn btn-info orders-inbox-edit"
                                       href="{{ route('orders.inbox.edit', $order->id) }}">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                @endif

                                @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_orders-inbox-delete")))
                                    <a class="btn btn-danger delete orders-inbox-delete"
                                       href="{{ route('orders.inbox.delete', $order->id) }}">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

                <div class="panel-footer">

                    {{ $orders->setPath('inbox')->render() }}
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

                    @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_orders-inbox-edit")))
                    $('.orders').dblclick(function (e) {
                        var href = $(e.currentTarget).find('a.orders-inbox-edit').attr('href');
                        window.location = href;
                    });
                    @else
                    $('.orders').dblclick(function (e) {
                        var href = $(e.currentTarget).find('a.orders-inbox-view').attr('href');
                        window.location = href;
                    });
                    @endif
                });
            </script>
@stop
