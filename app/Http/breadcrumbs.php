<?php

// Главная
Breadcrumbs::register('mainpage', function($breadcrumbs)
{
    $breadcrumbs->push('Главная', route('mainpage'));
});

// Приказы
Breadcrumbs::register('orders.index', function($breadcrumbs)
{
    $breadcrumbs->parent('mainpage');
    $breadcrumbs->push('Приказы', route('orders.index'));
});

// Приказы > Входящие
Breadcrumbs::register('orders.inbox', function($breadcrumbs)
{
    $breadcrumbs->parent('orders.index');
    $breadcrumbs->push('Входящие', route('orders.inbox', Session::get('paramStr')));
});

// Приказы > Входящие > Создать
Breadcrumbs::register('orders.inbox.create', function($breadcrumbs)
{
    $breadcrumbs->parent('orders.inbox');
    $breadcrumbs->push('Создать', route('orders.inbox.create'));
});

// Приказы > Входящие > Редактировать
Breadcrumbs::register('orders.inbox.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('orders.inbox');
    $breadcrumbs->push('Редактировать', route('orders.inbox.edit'));
});

// Приказы > Входящие > Просмотр
Breadcrumbs::register('orders.inbox.view', function($breadcrumbs)
{
    $breadcrumbs->parent('orders.inbox');
    $breadcrumbs->push('Просмотр', route('orders.inbox.view'));
});

// Приказы > Исходящие
Breadcrumbs::register('orders.outbox', function($breadcrumbs)
{
    $breadcrumbs->parent('orders.index');
    $breadcrumbs->push('Исходящие', route('orders.outbox'));
});

// Приказы > Исходящие > Создать
Breadcrumbs::register('orders.outbox.create', function($breadcrumbs)
{
    $breadcrumbs->parent('orders.outbox');
    $breadcrumbs->push('Создать', route('orders.outbox.create'));
});

// Приказы > Исходящие > Редактировать
Breadcrumbs::register('orders.outbox.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('orders.outbox');
    $breadcrumbs->push('Редактировать', route('orders.outbox.edit'));
});

// Приказы > Исходящие > Просмотр
Breadcrumbs::register('orders.outbox.view', function($breadcrumbs)
{
    $breadcrumbs->parent('orders.outbox');
    $breadcrumbs->push('Просмотр', route('orders.outbox.view'));
});

// Документы
Breadcrumbs::register('documents.index', function($breadcrumbs)
{
    $breadcrumbs->parent('mainpage');
    $breadcrumbs->push('Документы', route('documents.index'));
});

// Документы > Входящие
Breadcrumbs::register('documents.inbox', function($breadcrumbs)
{
    $breadcrumbs->parent('documents.index');
    $breadcrumbs->push('Входящие', route('documents.inbox'));
});

// Документы > Входящие > Создать
Breadcrumbs::register('documents.inbox.create', function($breadcrumbs)
{
    $breadcrumbs->parent('documents.inbox');
    $breadcrumbs->push('Создать', route('documents.inbox.create'));
});

// Документы > Входящие > Редактировать
Breadcrumbs::register('documents.inbox.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('documents.inbox');
    $breadcrumbs->push('Редактировать', route('documents.inbox.edit'));
});

// Документы > Входящие > Просмотр
Breadcrumbs::register('documents.inbox.view', function($breadcrumbs)
{
    $breadcrumbs->parent('documents.inbox');
    $breadcrumbs->push('Просмотр', route('documents.inbox.view'));
});

// Документы > Исходящие
Breadcrumbs::register('documents.outbox', function($breadcrumbs)
{
    $breadcrumbs->parent('documents.index');
    $breadcrumbs->push('Исходящие', route('documents.outbox'));
});

// Документы > Исходящие > Создать
Breadcrumbs::register('documents.outbox.create', function($breadcrumbs)
{
    $breadcrumbs->parent('documents.outbox');
    $breadcrumbs->push('Создать', route('documents.outbox.create'));
});

// Документы > Исходящие > Редактировать
Breadcrumbs::register('documents.outbox.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('documents.outbox');
    $breadcrumbs->push('Редактировать', route('documents.outbox.edit'));
});

// Документы > Исходящие > Просмотр
Breadcrumbs::register('documents.outbox.view', function($breadcrumbs)
{
    $breadcrumbs->parent('documents.outbox');
    $breadcrumbs->push('Просмотр', route('documents.outbox.view'));
});

// ДСП
Breadcrumbs::register('dsp.index', function($breadcrumbs)
{
    $breadcrumbs->parent('mainpage');
    $breadcrumbs->push('ДСП', route('dsp.index'));
});

// ДСП > Входящие
Breadcrumbs::register('dsp.inbox', function($breadcrumbs)
{
    $breadcrumbs->parent('dsp.index');
    $breadcrumbs->push('Входящие', route('dsp.inbox'));
});

// ДСП > Входящие > Создать
Breadcrumbs::register('dsp.inbox.create', function($breadcrumbs)
{
    $breadcrumbs->parent('dsp.inbox');
    $breadcrumbs->push('Создать', route('dsp.inbox.create'));
});

// ДСП > Входящие > Редактировать
Breadcrumbs::register('dsp.inbox.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('dsp.inbox');
    $breadcrumbs->push('Редактировать', route('dsp.inbox.edit'));
});

// ДСП > Входящие > Просмотр
Breadcrumbs::register('dsp.inbox.view', function($breadcrumbs)
{
    $breadcrumbs->parent('dsp.inbox');
    $breadcrumbs->push('Просмотр', route('dsp.inbox.view'));
});

// ДСП > Исходящие
Breadcrumbs::register('dsp.outbox', function($breadcrumbs)
{
    $breadcrumbs->parent('dsp.index');
    $breadcrumbs->push('Исходящие', route('dsp.outbox'));
});

// ДСП > Исходящие > Создать
Breadcrumbs::register('dsp.outbox.create', function($breadcrumbs)
{
    $breadcrumbs->parent('dsp.outbox');
    $breadcrumbs->push('Создать', route('dsp.outbox.create'));
});

// ДСП > Исходящие > Редактировать
Breadcrumbs::register('dsp.outbox.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('dsp.outbox');
    $breadcrumbs->push('Редактировать', route('dsp.outbox.edit'));
});

// ДСП > Исходящие > Просмотр
Breadcrumbs::register('dsp.outbox.view', function($breadcrumbs)
{
    $breadcrumbs->parent('dsp.outbox');
    $breadcrumbs->push('Просмотр', route('dsp.outbox.view'));
});

// Отчеты
Breadcrumbs::register('reports.index', function($breadcrumbs)
{
    $breadcrumbs->parent('mainpage');
    $breadcrumbs->push('Отчеты', route('reports.index'));
});

// Поиск
Breadcrumbs::register('search.index', function($breadcrumbs)
{
    $breadcrumbs->parent('mainpage');
    $breadcrumbs->push('Поиск', route('search.index'));
});



// // Home > Blog > [Category]
// Breadcrumbs::register('category', function($breadcrumbs, $category)
// {
//     $breadcrumbs->parent('blog');
//     $breadcrumbs->push($category->title, route('category', $category->id));
// });

// // Home > Blog > [Category] > [Page]
// Breadcrumbs::register('page', function($breadcrumbs, $page)
// {
//     $breadcrumbs->parent('category', $page->category);
//     $breadcrumbs->push($page->title, route('page', $page->id));
// });