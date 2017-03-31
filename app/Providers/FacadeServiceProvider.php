<?php

namespace App\Providers;


use App\Connectors\AirTable;
use App\Importers\Importer;
use Helpers\AppHelper;
use Illuminate\Support\ServiceProvider;

class FacadeServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('appHelper', function($app) {
            return new AppHelper();
        });

        $this->app->bind('airTable', function($app) {
            return new AirTable();
        });

        $this->app->bind('importer', function($app) {
            return new Importer();
        });
    }
}
