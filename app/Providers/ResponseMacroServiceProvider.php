<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use View;

use Jenssegers\Agent\Facades\Agent;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register the application's response macros.
     *
     * @return void
     *
     * Usage in method controller : response()->responsiveView('myView')
     * Depending on the user agent it will try to return the mobile view if necessary.
     */
    public function boot()
    {
        Response::macro('responsiveView', function ($viewname) {
            $mobileView = $viewname . '-mobile';

            $shouldReturnMobileView = (
                Agent::isPhone()
                && View::exists($mobileView)
            );

            return $shouldReturnMobileView ? View::make($mobileView) : View::make($viewname);
        });
    }
}
?>