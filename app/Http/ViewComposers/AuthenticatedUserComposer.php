<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\UserRepository;
use Auth;
use LinkedIn;

class AuthenticatedUserComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view
            ->with('linkedinUrl', route('candidate_redirect_to_linkedin'))
            ->with('disclaimerClosed', \Request::cookie('disclaimer_closed') == "1")
            ->with('user', Auth::user());
    }
}
?>