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



Route::get('/demotest', function(){
    dd(\App\User::getArrayOptions());
});

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

        // Сохранение входящего приказа
//        Route::post('/orders/inbox/create', [
//            'as' => 'orders.inbox.create',
//            'uses' => 'OrdersController@inboxSave',
//            'middleware' => 'has_perm:_superadmin,_orders-inbox-create'
//        ]);

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

        // Справочник "Номенклатурный номер" - сохранение
        Route::get('/admin/references/itemnumber/delete', [
            'as' => 'references.itemnumber.delete',
            'uses' => 'ReferencesController@itemNumberDelete'
        ]);



        // Справочник "Получатели"
        Route::get('/admin/references/recipients', [
            'as' => 'references.recipients',
            'uses' => 'ReferencesController@recipientsIndex'
        ]);
    });
});

Route::get('/test', function(){
    return view('test.test');
});