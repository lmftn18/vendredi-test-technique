<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class ModalInscriptionComposer
{
    /*
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('educations', \App\Education::orderBy('order')->get());
    }
}
?>
