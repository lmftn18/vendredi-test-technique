<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;

use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\MessageBag;
use Auth;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    
    use AuthenticatesUsers;
    
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        
        if ($request->wantsJson()) {
            $user = Auth::user();
            $fractal = new Manager();
            $resource = new Item($user->fresh(), new UserTransformer());
    
            return response()->json(array_merge(
              $fractal->createData($resource)->toArray(),
              ['success' => true]
            ));
            
        }
        
        $this->clearLoginAttempts($request);
        return $this->authenticated($request, $this->guard()->user())
          ?: redirect()->intended($this->redirectPath());
    }
    
    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        
        $request->session()->flush();
        
        $request->session()->regenerate();
        
        return redirect($this->redirectPath());
    }
    
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
    
    /**
     * Redirects to the current page if the parameter has been specified.
     *
     * @return string
     */
    public function redirectPath()
    {
        return Input::get('current_page', false) ?: \Route::get('home');
    }
    
    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        
        if ($request->wantsJson()) {
            return response()->json(['success' => false]);
        }
        return redirect()->back()
          ->withInput($request->only($this->username(), 'remember'))
          ->withErrors([
            $this->username() => \Lang::get('auth.failed'),
          ]);
    }
}
