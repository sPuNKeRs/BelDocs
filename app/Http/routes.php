<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

// Общая группа
Route::group(['middleware' => ['logged']], function () {
    Route::get('/', [
        'as' => 'mainpage',
        'uses' => 'PagesController@mainpage',
    ]);

    // --------------------------------------------------------
    // ------------------------  ПРИКАЗЫ ----------------------
    // --------------------------------------------------------

    // Группа для работы с приказами
    Route::group(['middleware' => []], function () {

        // Страница с приказами
        Route::get('/orders', [
            'as' => 'orders.index',
            'uses' => 'OrdersController@index'
        ]);

        // --------------------------------------------------------
        // ----------------- Входящие приказы ---------------------
        // --------------------------------------------------------

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

        // --------------------------------------------------------
        // ---------------- Исходящие приказы ---------------------
        // --------------------------------------------------------

        // Страница с исходящими приказами
        Route::get('/orders/outbox', [
            'as' => 'orders.outbox',
            'uses' => 'OrdersController@outbox'
        ]);

        // Страница создания входящего приказа
        Route::get('/orders/outbox/create', [
            'as' => 'orders.outbox.create',
            'uses' => 'OrdersController@outboxCreate',
            'middleware' => 'has_perm:_superadmin,_orders-outbox-create'
        ]);     

        // Сохранение входящего приказа AJAX
        Route::post('/orders/outbox/create', [
            'as' => 'orders.outbox.create',
            'uses' => 'OrdersController@outboxSaveAjax',
            'middleware' => 'has_perm:_superadmin,_orders-outbox-create'
        ]);

        // Отмена создания приказа
        Route::get('/orders/outbox/cancel', [
            'as' => 'orders.outbox.cancel',
            'uses' => 'OrdersController@outboxOrderCancel', 
            'middleware' => 'has_perm:_superadmin,_orders-outbox-create'
        ]);

        // Страница редактирования входящего приказа
        Route::get('/orders/outbox/edit/{id?}', [
            'as' => 'orders.outbox.edit',
            'uses' => 'OrdersController@outboxOrdersEdit',
            'middleware' => 'has_perm:_superadmin,_orders-outbox-edit'
        ]);

        // Страница просмотра входящего приказа
        Route::get('/orders/outbox/view/{id?}', [
            'as' => 'orders.outbox.view',
            'uses' => 'OrdersController@viewOutbox',
            'middleware' => 'has_perm:_superadmin,_orders-outbox-view'
        ]);

        // // Обновление входящего приказа
        // Route::post('/orders/outbox/update', [
        //     'as' => 'orders.outbox.update',
        //     'uses' => 'OrdersController@outboxOrdersUpdate',
        //     'middleware' => 'has_perm:_superadmin,_orders-outbox-edit'
        // ]);

        // Удаление входящего приказа
        Route::get('/orders/outbox/delete/{id?}',[
            'as' => 'orders.outbox.delete',
            'uses' => 'OrdersController@outboxOrdersDelete',
            'middleware' => 'has_perm:_superadmin,_orders-outbox-delete'
        ]);
    });

    // --------------------------------------------------------
    // ---------------------  КОММЕНТАРИИ ---------------------
    // --------------------------------------------------------

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

    // --------------------------------------------------------
    // -----------------------  ДОКУМЕНТЫ ---------------------
    // --------------------------------------------------------

    // Группа для работы с документами
    Route::group(['middleware' => []], function () {
        // Страница с приказами
        Route::get('/documents', [
            'as' => 'documents.index',
            'uses' => 'DocumentsController@index'
        ]);
        // --------------------------------------------------------
        // -----------------  Входящие документы ------------------
        // --------------------------------------------------------

        // Страница с входящими документами
        Route::get('/documents/inbox', [
            'as' => 'documents.inbox',
            'uses' => 'DocumentsController@inbox'
        ]);

        // Страница создания входящего документа
        Route::get('/documents/inbox/create', [
            'as' => 'documents.inbox.create', 
            'uses' => 'DocumentsController@inboxCreate', 
            'middleware' => 'has_perm:_superadmin,_documents-inbox-create'
        ]);

        // Сохранение входящего документа
        Route::post('/documents/inbox/save', [
            'as' => 'documents.inbox.save', 
            'uses' => 'DocumentsController@inboxSave',
            'middleware' => 'has_perm:_superadmin,_documents-inbox-create'
        ]);

        // Отмена создания входящего документа
        Route::get('/documents/inbox/cancel', [
            'as' => 'documents.inbox.cancel', 
            'uses' => 'DocumentsController@inboxCancel', 
            'middleware' => 'has_perm:_superadmin,_documents-inbox-create'
        ]);

        // Страница редактирования входящего документа
        Route::get('/documents/inbox/edit/{id?}', [
            'as' => 'documents.inbox.edit', 
            'uses' => 'DocumentsController@inboxEdit', 
            'middleware' => 'has_perm:_superadmin,_documents-inbox-edit'
        ]);

        // Страница просмотра входящего документа
        Route::get('/documents/inbox/view/{id?}', [
            'as' => 'documents.inbox.view', 
            'uses' => 'DocumentsController@inboxView', 
            'middleware' => 'has_perm:_superadmin,_documents-inbox-view'
        ]);

        // Удаление входящего документа
        Route::get('/documents/inbox/delete/{id?}', [
            'as' => 'documents.inbox.delete', 
            'uses' => 'DocumentsController@inboxDelete',
            'middleware' => 'has_perm:_superadmin,_documents-inbox-delete'
        ]);

        // --------------------------------------------------------
        // ----------------- Исходящие документы ------------------
        // --------------------------------------------------------

        // Страница с  исходящими документами
        Route::get('/documents/outbox', [
            'as' => 'documents.outbox',
            'uses' => 'DocumentsController@outbox'
        ]);

        // Страница создания исходящего документа
        Route::get('/documents/outbox/create', [
            'as' => 'documents.outbox.create', 
            'uses' => 'DocumentsController@outboxCreate', 
            'middleware' => 'has_perm:_superadmin,_documents-outbox-create'
        ]);

        // Сохранение исходящего документа
        Route::post('/documents/outbox/save', [
            'as' => 'documents.outbox.save', 
            'uses' => 'DocumentsController@outboxSave',
            'middleware' => 'has_perm:_superadmin,_documents-outbox-create'
        ]);

        // Отмена создания исходящего документа
        Route::get('/documents/outbox/cancel', [
            'as' => 'documents.outbox.cancel', 
            'uses' => 'DocumentsController@outboxCancel', 
            'middleware' => 'has_perm:_superadmin,_documents-outbox-create'
        ]);

        // Страница редактирования исходящего документа
        Route::get('/documents/outbox/edit/{id?}', [
            'as' => 'documents.outbox.edit', 
            'uses' => 'DocumentsController@outboxEdit', 
            'middleware' => 'has_perm:_superadmin,_documents-outbox-edit'
        ]);

        // Страница просмотра исходящего документа
        Route::get('/documents/outbox/view/{id?}', [
            'as' => 'documents.outbox.view', 
            'uses' => 'DocumentsController@outboxView', 
            'middleware' => 'has_perm:_superadmin,_documents-outbox-view'
        ]);

        // Удаление исходящего документа
        Route::get('/documents/outbox/delete/{id?}', [
            'as' => 'documents.outbox.delete', 
            'uses' => 'DocumentsController@outboxDelete',
            'middleware' => 'has_perm:_superadmin,_documents-outbox-delete'
        ]);
    });

    // --------------------------------------------------------
    // ----------------------- ДСП ----------------------------
    // --------------------------------------------------------

    // Группа для работы с ДСП
    Route::group(['middleware' => []], function () {
        // Страница с ДСП
        Route::get('/dsp', [
            'as' => 'dsp.index',            
            'uses' => 'DspsController@index',
            'middleware' => 'has_perm:_superadmin,has_perm:_dsp.index'
        ]);

        // --------------------------------------------------------
        // -------------------- Входящие ДСП ----------------------
        // --------------------------------------------------------

        // Страница с входящими ДСП
        Route::get('/dsp/inbox', [
            'as' => 'dsp.inbox',
            'uses' => 'DspsController@inbox'
        ]);

        // Страница создания входящего ДСП
        Route::get('/dsp/inbox/create', [
            'as' => 'dsp.inbox.create', 
            'uses' => 'DspsController@inboxCreate', 
            'middleware' => 'has_perm:_superadmin,_dsp-inbox-create'
        ]);

        // Сохранение входящего ДСП
        Route::post('/dsp/inbox/save', [
            'as' => 'dsp.inbox.save', 
            'uses' => 'DspsController@inboxSave',
            'middleware' => 'has_perm:_superadmin,_dsp-inbox-create'
        ]);

        // Отмена создания входящего ДСП
        Route::get('/dsp/inbox/cancel', [
            'as' => 'dsp.inbox.cancel', 
            'uses' => 'DspsController@inboxCancel', 
            'middleware' => 'has_perm:_superadmin,_dsp-inbox-create'
        ]);

        // Страница редактирования входящего ДСП
        Route::get('/dsp/inbox/edit/{id?}', [
            'as' => 'dsp.inbox.edit', 
            'uses' => 'DspsController@inboxEdit', 
            'middleware' => 'has_perm:_superadmin,_dsp-inbox-edit'
        ]);

        // Страница просмотра входящего ДСП
        Route::get('/dsp/inbox/view/{id?}', [
            'as' => 'dsp.inbox.view', 
            'uses' => 'DspsController@inboxView', 
            'middleware' => 'has_perm:_superadmin,_dsp-inbox-view'
        ]);

        // Удаление входящего ДСП
        Route::get('/dsp/inbox/delete/{id?}', [
            'as' => 'dsp.inbox.delete', 
            'uses' => 'DspsController@inboxDelete',
            'middleware' => 'has_perm:_superadmin,_dsp-inbox-delete'
        ]);

        // --------------------------------------------------------
        // ----------------- Исходящие ДСП ------------------------
        // --------------------------------------------------------

        // Страница с Исходящими ДСП
        Route::get('/dsp/outbox', [
            'as' => 'dsp.outbox',
            'uses' => 'DspsController@outbox'
        ]);

        // Страница создания исходящего ДСП
        Route::get('/dsp/outbox/create', [
            'as' => 'dsp.outbox.create', 
            'uses' => 'DspsController@outboxCreate', 
            'middleware' => 'has_perm:_superadmin,_dsp-outbox-create'
        ]);

        // Сохранение исходящего ДСП
        Route::post('/dsp/outbox/save', [
            'as' => 'dsp.outbox.save', 
            'uses' => 'DspsController@outboxSave',
            'middleware' => 'has_perm:_superadmin,_dsp-outbox-create'
        ]);

        // Отмена создания исходящего ДСП
        Route::get('/dsp/outbox/cancel', [
            'as' => 'dsp.outbox.cancel', 
            'uses' => 'DspsController@outboxCancel', 
            'middleware' => 'has_perm:_superadmin,_dsp-outbox-create'
        ]);

        // Страница редактирования исходящего ДСП
        Route::get('/dsp/outbox/edit/{id?}', [
            'as' => 'dsp.outbox.edit', 
            'uses' => 'DspsController@outboxEdit', 
            'middleware' => 'has_perm:_superadmin,_dsp-outbox-edit'
        ]);

        // Страница просмотра исходящего ДСП
        Route::get('/dsp/outbox/view/{id?}', [
            'as' => 'dsp.outbox.view', 
            'uses' => 'DspsController@outboxView', 
            'middleware' => 'has_perm:_superadmin,_dsp-outbox-view'
        ]);

        // Удаление исходящего ДСП
        Route::get('/dsp/outbox/delete/{id?}', [
            'as' => 'dsp.outbox.delete', 
            'uses' => 'DspsController@outboxDelete',
            'middleware' => 'has_perm:_superadmin,_dsp-outbox-delete'
        ]);
    });

    // --------------------------------------------------------
    // ---------------------- ОТЧЕТЫ --------------------------
    // --------------------------------------------------------

    // Группа для работы с отчетами
    Route::group(['middleware' => []], function () {
        // Страница с отчетами
        Route::get('/reports', [
            'as' => 'reports.index',
            'uses' => 'ReportsController@index'
        ]);

        Route::post('/reports/generate', [
            'as' => 'reports.generate',
            'uses' => 'ReportsController@generate'
        ]);
    });

    // --------------------------------------------------------
    // ------------------------- ПОИСК ------------------------
    // --------------------------------------------------------
        
    // Группа для работы с поиском
    Route::group(['middleware' => []], function () {
        // Страница с отчетами
        Route::get('/search', [
            'as' => 'search.index',
            'uses' => 'SearchController@index'
        ]);
    });

    // --------------------------------------------------------
    // ----------------- ВЛОЖЕНИЯ (ФАЙЛЫ) ---------------------
    // --------------------------------------------------------

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

    // --------------------------------------------------------
    // --------------------- ОТВЕТСВЕННЫЕ ---------------------
    // --------------------------------------------------------

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

    // --------------------------------------------------------
    // ----------------- СПРАВОЧНИКИ --------------------------
    // --------------------------------------------------------

    // Группа для работы со справочниками
    Route::group(['middleware' => []], function(){
        // Страница со справочниками
        Route::get('/admin/references/index', [
            'as' => 'references.index',
            'uses' => 'ReferencesController@index'
        ]);
        // --------------------------------------------------------
        // ----------------- Номенклатурный номер -----------------
        // --------------------------------------------------------

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

        // --------------------------------------------------------
        // --------------- Номенклатурный номер ДСП ---------------
        // --------------------------------------------------------

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

        // --------------------------------------------------------
        // --------------------- Получатели -----------------------
        // --------------------------------------------------------

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

        // --------------------------------------------------------
        // ----------------- Получатели ДСП -----------------------
        // --------------------------------------------------------

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

        // --------------------------------------------------------
        // -------------------- Отправители -----------------------
        // --------------------------------------------------------

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

        // --------------------------------------------------------
        // --------------------- Заявители  -----------------------
        // --------------------------------------------------------

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