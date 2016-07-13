<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Общая группа
Route::group(['middleware' => ['logged']], function () {
    Route::get('/', [
        'as' => 'mainpage',
        'uses' => 'PagesController@mainpage',
    ]);

    // Группа для работы с приказами
    Route::group(['middleware' => []], function () {
        // Страница с приказами
        Route::get('/orders', [
            'as' => 'orders.index',
            'uses' => 'OrdersController@index'
        ]);

        // Страница с входящими приказами
        Route::get('/orders/inbox', [
            'as' => 'orders.inbox',
            'uses' => 'OrdersController@inbox'
        ]);

        // Страница создания входящего приказа
        Route::get('/orders/inbox/create', [
            'as' => 'orders.inbox.create',
            'uses' => 'OrdersController@inboxCreate'
        ]);

        // Сохранение входящего приказа
        Route::post('/orders/inbox/create', [
            'uses' => 'OrdersController@inboxSave'
        ]);


        // Страница с исходящими приказами

        Route::get('/orders/outbox', [
            'as' => 'orders.outbox',
            'uses' => 'OrdersController@outbox'
        ]);
    });

    // Группа для работы с документами
    Route::group(['middleware' => []], function () {
        // Страница с приказами
        Route::get('/documents', [
            'as' => 'documents.index',
            'uses' => 'DocumentsController@index'
        ]);

        // Страница с входящими документами
        Route::get('/documents/inbox', [
            'as' => 'documents.inbox',
            'uses' => 'DocumentsController@inbox'
        ]);

        // Страница с  исходящими документами
        Route::get('/documents/outbox', [
            'as' => 'documents.outbox',
            'uses' => 'DocumentsController@outbox'
        ]);
    });

// Группа для работы с ДСП
    Route::group(['middleware' => []], function () {
        // Страница с ДСП
        Route::get('/dsp', [
            'as' => 'dsp.index',
            'middleware' => 'has_perm:_dsp.index',
            'uses' => 'DspsController@index'
        ]);

        // Страница с входящими ДСП
        Route::get('/dsp/inbox', [
            'as' => 'dsp.inbox',
            'uses' => 'DspsController@inbox'
        ]);

        // Страница с Исходящими ДСП
        Route::get('/dsp/outbox', [
            'as' => 'dsp.outbox',
            'uses' => 'DspsController@outbox'
        ]);
    });

    // Группа для работы с отчетами
    Route::group(['middleware' => []], function () {
        // Страница с отчетами
        Route::get('/reports', [
            'as' => 'reports.index',
            'uses' => 'ReportsController@index'
        ]);
    });

    // Группа для работы с отчетами
    Route::group(['middleware' => []], function () {
        // Страница с отчетами
        Route::get('/search', [
            'as' => 'search.index',
            'uses' => 'SearchController@index'
        ]);
    });
});

Route::get('/test', function(){
    return view('test.test');
});




