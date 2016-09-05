<?php

namespace App\Providers;

use App\Helpers\SortHelper;
use Illuminate\Support\Facades\Config;
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
        Blade::directive('sortLink', function ($expression) {
            return "<?php echo SortHelper::link(array {$expression});?>";
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
