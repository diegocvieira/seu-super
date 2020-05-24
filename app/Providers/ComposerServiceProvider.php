<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['admin.market.create-edit'], 'App\Http\ViewComposers\PaymentsComposer');
        view()->composer(['admin.market.create-edit'], 'App\Http\ViewComposers\DistrictsComposer');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
