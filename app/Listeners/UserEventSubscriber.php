<?php

namespace App\Listeners;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Session;
class UserEventSubscriber
{

    /**
     * Handle user login events.
     */
    public function onUserLogin($event) {
        
        $messageBag = Session::get('success', new MessageBag());
        $messageBag->add('default', 'Vous êtes bien connecté !');
        Session::flash('success', $messageBag);
    }


    public function onUserRegister($event) {
        $messageBag = Session::get('success', new MessageBag());
        $messageBag->add('default',  'Bienvenue ' . $event->user->firstname . ', vous êtes bien enregistré sur Vendredi.cc !');
        Session::flash('success', $messageBag);
    }
    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {

        /* temporarily disable message
        $events->listen(
            'Illuminate\Auth\Events\Registered',
            'App\Listeners\UserEventSubscriber@onUserRegister'
        );

        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@onUserLogin'
        );
        */
    }

}
?>