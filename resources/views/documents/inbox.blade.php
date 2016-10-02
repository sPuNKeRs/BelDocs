<?php

    use Illuminate\Support\Facades\Input;

?>

@extends('layouts.master')

@section('title', 'Входящие документы')
@section('description', '')
@section('keywords', '')

@section('pageClass', 'main page')

@section('toolsbar')
    @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_documents-inbox-create")))
        <a class='btn' data-toggle='toolbar-tooltip' href='{{ route('documents.inbox.create')}}' title='Создать документ'>
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
                    Входящие документы
                    <div class="panel-tools">                        
                        <div class="badge">{{ $count }} записей</div>
                    </div>
                </div>
                <div class="wrapper-height">
                <table class="table">
                    <thead>
                    <tr>
                        <th>@sortLink('doc_num', '#')</th>
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

                    @foreach($inbox_documents as $document)
                        <tr class="documents {{ isset($document->status) ? 'success' : '' }} {{ ($document->draft == 1)?'draft' : ''}}">
                            <td>{{$document->doc_num}}</td>
                            <td>{{ (isset($document->item_number)) ? $document->item_number->item_number : '' }}</td>
                            <td>{{$document->incoming_number}}</td>
                            <td>{{$document->title}}</td>
                            <td>{{ date('d.m.Y', strtotime($document->create_date)) }}</td>
                            <td>{{ date('d.m.Y', strtotime($document->execute_date)) }}</td>
                            <td>{{ isset($document->status) ? 'Исполнен' : 'Не исполнен' }} </td>
                            <td class="action">
                            
                                @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_documents-inbox-view")))
                                    <a class="btn btn-success orders-inbox-view"
                                       href="{{ route('documents.inbox.view', $document->id) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                @endif

                                @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_documents-inbox-edit")))
                                    <a class="btn btn-info documents-inbox-edit"
                                       href="{{ route('documents.inbox.edit', $document->id) }}">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                @endif

                                @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_documents-inbox-delete")))
                                    <a class="btn btn-danger delete documents-inbox-delete"
                                       href="{{ route('documents.inbox.delete', $document->id) }}">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                @endif

                                @if($document->draft == 1)
                                    <i class="fa fa-question-circle-o" title="Черновик"></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                </div>

                <div class="panel-footer" style="min-height: 54px;">

                    {{ $inbox_documents->setPath('inbox')->appends(Input::except('page'))->render() }}
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

                    @if(App::make('authentication_helper')->hasPermission(array("_superadmin", "_documents-inbox-edit")))
                    $('.documents').dblclick(function (e) {
                        var href = $(e.currentTarget).find('a.documents-inbox-edit').attr('href');
                        window.location = href;
                    });
                    @else
                    $('.documents').dblclick(function (e) {
                        var href = $(e.currentTarget).find('a.documents-inbox-view').attr('href');
                        window.location = href;
                    });
                    @endif
                });
            </script>
@stop
