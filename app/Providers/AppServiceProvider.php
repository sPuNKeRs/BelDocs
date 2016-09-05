<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Директива для blade - формирование ссылки для сортировки
        Blade::directive('sortLink', function($arguments){



//            if(Request::has('page'))
//            {
//                $page = Request::input('page');
//            }

            list($column, $title, $page) = explode(',',str_replace(['(',')',' ', "'"], '', $arguments));
            $link = '<a href="'.url(Request::path()).'?sort='.$column.'&order=asc'.(isset($page) ? '&page='.$page: '').'">'.$title.'</a> <i class="fa fa-sort"></i>';

            return $link;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
