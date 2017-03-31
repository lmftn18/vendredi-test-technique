<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\MessageBag;
use Session;

class CheckRole
{
    const BAD_ROLE_ERROR = "Vous n'avez pas les permissions requises pour réaliser cette action. Etes-vous bien connecté?";
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     */
    public function __construct( Guard $auth )
    {
        $this->auth = $auth;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string                   $role
     *
     * @return mixed
     */
    public function handle( $request, Closure $next, $role )
    {
        
        if ( $this->auth->guest() ) {
            if ( $request->ajax() ) {
                return response( 'Unauthorized.', 401 );
            } else {
                $this->addBadRoleFlash();
                return redirect()->guest(
                    strpos($request->route()->getPrefix(), '/admin') !== false
                        ?  '/admin/login'
                        : '/'
                );
            }
        }

        if ( auth()->check() && $request->user()->hasRole( $role ) ) {
            return $next( $request );
        }

        $this->addBadRoleFlash();
        return redirect()->back();
    }

    /**
     * add the error to the session stack in a message bag
     * to be compatible with the validations errors
     */
    private function addBadRoleFlash()
    {
        $messageBag = Session::get('errors', new MessageBag());
        $messageBag->add('default', static::BAD_ROLE_ERROR);
        Session::flash('errors', $messageBag);
    }
}
