<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer('*', 'App\Http\ViewComposers\AuthenticatedUserComposer');
        // this only needs to be injected once on the public site
        \View::composer(['layouts.main', 'layouts.main-mobile'], 'App\Http\ViewComposers\ModalInscriptionComposer');
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
