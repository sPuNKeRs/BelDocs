<?php

    use Illuminate\Support\Facades\Input;

?>

@extends('layouts.master')

@section('title', 'Входящие приказы')
@section('description', '')
@section('keywords', '')

@section('pageClass', 'main page')

@section('toolsbar')
    @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_orders-inbox-create")))
        <a class='btn' data-toggle='toolbar-tooltip' href='{{ route('orders.inbox.create')}}' title='Создать приказ'>
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
                    Входящие приказы
                    <div class="panel-tools">                        
                        <div class="badge">{{ $count }} записей</div>
                    </div>
                </div>
                <div class="wrapper-height">
                <table class="table">
                    <thead>
                    <tr>
                        <th>@sortLink('order_num', '#')</th>
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

                    @foreach($orders as $order)
                        <tr class="orders {{ isset($order->status) ? 'success' : '' }} {{ ($order->draft == 1)?'draft' : ''}}">
                            <td>{{$order->entity_num}}</td>
                            <td>{{ (isset($order->item_number)) ? $order->item_number->item_number : '' }}</td>
                            <td>{{$order->incoming_number}}</td>
                            <td>{{$order->title}}</td>
                            <td>{{ date('d.m.Y', strtotime($order->create_date)) }}</td>
                            <td>{{ date('d.m.Y', strtotime($order->execute_date)) }}</td>
                            <td>{{ isset($order->status) ? 'Исполнен' : 'Не исполнен' }} </td>
                            <td class="action">
                            
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

                                @if($order->draft == 1)
                                    <i class="fa fa-question-circle-o" title="Черновик"></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                </div>

                <div class="panel-footer" style="min-height: 54px;">

                    {{ $orders->setPath('inbox')->appends(Input::except('page'))->render() }}
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
