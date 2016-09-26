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
            'uses' => 'OrdersController@inboxCreate',
            'middleware' => 'has_perm:_superadmin,_orders-inbox-create'
        ]);     

        // Сохранение входящего приказа AJAX
        Route::post('/orders/inbox/create', [
            'as' => 'orders.inbox.create',
            'uses' => 'OrdersController@inboxSaveAjax',
            'middleware' => 'has_perm:_superadmin,_orders-inbox-create'
        ]);

        // Отмена создания приказа
        Route::get('/orders/inbox/cancel', [
            'as' => 'orders.inbox.cancel',
            'uses' => 'OrdersController@orderCancel'
        ]);

        // Страница редактирования входящего приказа
        Route::get('/orders/inbox/edit/{id?}', [
            'as' => 'orders.inbox.edit',
            'uses' => 'OrdersController@edit',
            'middleware' => 'has_perm:_superadmin,_orders-inbox-edit'
        ]);

        // Страница просмотра входящего приказа
        Route::get('/orders/inbox/view/{id?}', [
            'as' => 'orders.inbox.view',
            'uses' => 'OrdersController@viewInbox',
            'middleware' => 'has_perm:_superadmin,_orders-inbox-view'
        ]);

        // Обновление входящего приказа
        Route::post('/orders/inbox/update', [
            'as' => 'orders.inbox.update',
            'uses' => 'OrdersController@update',
            'middleware' => 'has_perm:_superadmin,_orders-inbox-edit'
        ]);

        // Удаление входящего приказа
        Route::get('/orders/inbox/delete/{id?}',[
            'as' => 'orders.inbox.delete',
            'uses' => 'OrdersController@delete',
            'middleware' => 'has_perm:_superadmin,_orders-inbox-delete'
        ]);

        // Страница с исходящими приказами
        Route::get('/orders/outbox', [
            'as' => 'orders.outbox',
            'uses' => 'OrdersController@outbox'
        ]);
    });

    // Группа для работы с комментариями
    Route::group(['middleware' => []],function(){
        // Сохранить комментарий
        Route::post('/comments/store', [
            'as' => 'comments.store',
            'uses' => 'CommentsController@store'
        ]);

        // Удалить комментарий
        Route::post('/comments/delete/{id?}', [
            'as' => 'comments.delete',
            'uses' => 'CommentsController@delete'
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

    // Группа для работы с вложениями
    Route::group(['middlewate'=>[]], function(){
        Route::post('/attachments/store', [
            'as' => 'attachments.store',
            'uses' => 'AttachmentsController@store'
        ]);

        Route::post('/attachments/destroy',[
            'as' => 'attachments.destroy',
            'uses' => 'AttachmentsController@destroy'
        ]);

        Route::post('/attachments/geturl', [
            'as' => 'attachments.geturl',
            'uses' => 'AttachmentsController@getUrl'
        ]);
    });

    // Группа для работы с ответственными лицами
    Route::group(['middleware' => []], function(){
        Route::get('/responsible/store', 'ResponsibleController@store');

        Route::post('/responsible/store', [
            'as' => 'responsible.store',
            'uses' => 'ResponsibleController@store'
        ]);

        Route::post('/responsible/getResponsibleTpl', [
            'as' => 'responsible.getResponsibleTpl',
            'uses' => 'ResponsibleController@getResponsibleTpl'
        ]);
        
        Route::post('/responsible/destroy', [
            'as' => 'responsible.destroy',
            'uses' => 'ResponsibleController@destroy'
        ]);
    });

    // Группа для работы со справочниками
    Route::group(['middleware' => []], function(){
        // Страница со справочниками
        Route::get('/admin/references/index', [
            'as' => 'references.index',
            'uses' => 'ReferencesController@index'
        ]);

        // Справочник "Номенклатурный номер"
        Route::get('/admin/references/itemnumber', [
            'as' => 'references.itemnumber',
            'uses' => 'ReferencesController@itemNumbersIndex'
        ]);

        // Справочник "Номенклатурный номер" - форма добавления
        Route::get('/admin/references/itemnumber/edit', [
            'as' => 'references.itemnumber.edit',
            'uses' => 'ReferencesController@itemNumbersEdit'
        ]);

        // Справочник "Номенклатурный номер" - сохранение
        Route::post('/admin/references/itemnumber/edit', [
            'as' => 'references.itemnumber.edit',
            'uses' => 'ReferencesController@itemNumbersPost'
        ]);

        // Справочник "Номенклатурный номер" - удаление
        Route::get('/admin/references/itemnumber/delete', [
            'as' => 'references.itemnumber.delete',
            'uses' => 'ReferencesController@itemNumberDelete'
        ]);

        // Справочник "Номенклатурный номер ДСП"
        Route::get('/admin/references/itemnumber_dsp', [
            'as' => 'references.itemnumber_dsp',
            'uses' => 'ReferencesController@itemNumbers_dspIndex'
        ]);

        // Справочник "Номенклатурный номер ДСП" - форма добавления
        Route::get('/admin/references/itemnumber_dsp/edit', [
            'as' => 'references.itemnumber_dsp.edit',
            'uses' => 'ReferencesController@itemNumbers_dspEdit'
        ]);

        // Справочник "Номенклатурный номер ДСП" - сохранение
        Route::post('/admin/references/itemnumber_dsp/edit', [
            'as' => 'references.itemnumber_dsp.edit',
            'uses' => 'ReferencesController@itemNumbers_dspPost'
        ]);

        // Справочник "Номенклатурный номер ДСП" - удаление
        Route::get('/admin/references/itemnumber_dsp/delete', [
            'as' => 'references.itemnumber_dsp.delete',
            'uses' => 'ReferencesController@itemNumber_dspDelete'
        ]);

        // Справочник "Получатели"
        Route::get('/admin/references/recipient', [
            'as' => 'references.recipient',
            'uses' => 'ReferencesController@recipientsIndex'
        ]);

         // Справочник "Получатели" - форма добавления
        Route::get('/admin/references/recipient/edit', [
            'as' => 'references.recipient.edit',
            'uses' => 'ReferencesController@recipientEdit'
        ]);

        // Справочник "Получатели" - сохранение
        Route::post('/admin/references/recipient/edit', [
            'as' => 'references.recipient.edit',
            'uses' => 'ReferencesController@recipientPost'
        ]);

        // Справочник "Получатели" - удаление
        Route::get('/admin/references/recipient/delete', [
            'as' => 'references.recipient.delete',
            'uses' => 'ReferencesController@recipientDelete'
        ]);

        // Справочник "Получатели ДСП"
        Route::get('/admin/references/recipient_dsp', [
            'as' => 'references.recipient_dsp',
            'uses' => 'ReferencesController@recipient_dspIndex'
        ]);

         // Справочник "Получатели ДСП" - форма добавления
        Route::get('/admin/references/recipient_dsp/edit', [
            'as' => 'references.recipient_dsp.edit',
            'uses' => 'ReferencesController@recipient_dspEdit'
        ]);

        // Справочник "Получатели ДСП" - сохранение
        Route::post('/admin/references/recipient_dsp/edit', [
            'as' => 'references.recipient_dsp.edit',
            'uses' => 'ReferencesController@recipient_dspPost'
        ]);

        // Справочник "Получатели ДСП" - удаление
        Route::get('/admin/references/recipient_dsp/delete', [
            'as' => 'references.recipient_dsp.delete',
            'uses' => 'ReferencesController@recipient_dspDelete'
        ]);

        // Справочник "Отправители"
        Route::get('/admin/references/sender', [
            'as' => 'references.sender', 
            'uses' => 'ReferencesController@sendersIndex'
        ]);

        // Справочник "Отправители" - форма добавления / редактирования
        Route::get('/admin/references/sender/edit', [
            'as' => 'references.sender.edit',
            'uses' => 'ReferencesController@senderEdit'
        ]);

        // Справочник "Отправители" - сохранение
        Route::post('/admin/references/sender/edit', [
            'as' => 'references.sender.edit',
            'uses' => 'ReferencesController@senderPost'
        ]);

        // Справочник "Отправители" - удаление
        Route::get('/admin/references/sender/delete', [
            'as' => 'references.sender.delete',
            'uses' => 'ReferencesController@senderDelete'
        ]);

        // Справочник "Заявители"
        Route::get('/admin/references/declarer', [
            'as' => 'references.declarer', 
            'uses' => 'ReferencesController@declarersIndex'
        ]);

        // Справочник "Заявители" - форма добавления / редактирования
        Route::get('/admin/references/declarer/edit', [
            'as' => 'references.declarer.edit',
            'uses' => 'ReferencesController@declarerEdit'
        ]);

        // Справочник "Заявители" - сохранение
        Route::post('/admin/references/declarer/edit', [
            'as' => 'references.declarer.edit',
            'uses' => 'ReferencesController@declarerPost'
        ]);

        // Справочник "Заявители" - удаление
        Route::get('/admin/references/declarer/delete', [
            'as' => 'references.declarer.delete',
            'uses' => 'ReferencesController@declarerDelete'
        ]);
    });
});