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
    $breadcrumbs->push('Входящие', route('orders.inbox'));
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

// Приказы > Исходящие
Breadcrumbs::register('orders.outbox', function($breadcrumbs)
{
    $breadcrumbs->parent('orders.index');
    $breadcrumbs->push('Исходящие', route('orders.outbox'));
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

// Документы > Исходящие
Breadcrumbs::register('documents.outbox', function($breadcrumbs)
{
    $breadcrumbs->parent('documents.index');
    $breadcrumbs->push('Исходящие', route('documents.outbox'));
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

// ДСП > Исходящие
Breadcrumbs::register('dsp.outbox', function($breadcrumbs)
{
    $breadcrumbs->parent('dsp.index');
    $breadcrumbs->push('Исходящие', route('dsp.outbox'));
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