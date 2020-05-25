<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!app()->environment('local')) {
            \URL::forceScheme('https');

            \Illuminate\Pagination\AbstractPaginator::currentPathResolver(function () {
                return app('url')->current();
            });
        }
    }
}
