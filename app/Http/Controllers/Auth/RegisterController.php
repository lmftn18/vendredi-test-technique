<?php

namespace App\Http\Controllers\Auth;

use App\Candidate;
use App\Education;
use App\School;
use App\Transformers\UserTransformer;
use App\User;
use App\Http\Controllers\Controller;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;


use Happyr\LinkedIn\Storage\SessionStorage;
use Illuminate\Validation\ValidationException;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Newsletter;
use Validator;
use LinkedIn;
use Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    
    use RegistersUsers;
    
    /**
     * Where to redirect users after login / registration.
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
        $this->middleware('guest');
    }
    
    /**
     * Redirect to linkedin and stores the next page in the state
     *
     * @return string
     */
    public function redirectToLinkedin(Request $request)
    {
        $toEncrypt = str_random(5) . '#' . $this->redirectPath();
        $encrypted = encrypt($toEncrypt);
        $url = LinkedIn::getLoginUrl(['state' => $encrypted, 'redirect_uri' => route('candidate_login_linkedin')]);
        
        // We override the stored state to match it properly on request callback
        $storage = new SessionStorage();
        $storage->set('state', $encrypted);
        return redirect($url);
    }
    
    /**
     * Redirects to the current page if the parameter has been specified.
     *
     * @return string
     */
    public function redirectPath()
    {
        return \Request::input('current_page', false) ?: route('home');
    }
    
    /**
     * Authenticate via linkedin and redirects
     *
     * @return string
     */
    public function linkedin(Request $request)
    {
        $redirectUrl = $this->redirectPath();

        if (LinkedIn::isAuthenticated()) {
            
            //we know that the user is authenticated now. Start query the API
            $userLinkedinData = LinkedIn::get('v1/people/~:(firstName,lastName,emailAddress)');
    
            // We check the state
            $decrypted = decrypt(Input::get('state'));
            
            if (!preg_match('/[a-zA-Z0-9]{5}#[a-zA-Z%0-9]*/', $decrypted)) {
                app()->abort(401, 'Not authenticated');
            }
            
            $decryptedExploded = explode('#', $decrypted);
            
            // It has gone through 2 url encoding
            $redirectUrl = urldecode($decryptedExploded[1]);
            
            $user = \App\User::where(['email' => $userLinkedinData['emailAddress']])->first();
            
            if ($user == null) {
                $user = $this->create([
                  'email' => $userLinkedinData['emailAddress'],
                  'firstname' => $userLinkedinData['firstName'],
                  'lastname' => $userLinkedinData['lastName'],
                  'password' => str_random(8),// Random password
                  'education' => false,
                
                ]);
            } else {
                Newsletter::subscribeOrUpdate($user->email, ['MMERGE5' => $user->firstname, 'MMERGE4' => $user->lastname], 'subscribers');
            }
            Auth::login($user);
            
            return view('users/_redirect_after_linkedin')
              ->with('userInfo', [
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'email' => $user->email,
                'created_at_timestamp' => $user->created_at->timestamp,
                'user_hash' => hash_hmac("sha256", $user->email, "ET-F17JC5ZOZUqRiR9Ju7TZvhVOnpW8DbFxsf1LX")
              ])
              ->with('redirect_url', $redirectUrl);
        }
        
        return redirect($redirectUrl);
    }
    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        // start the transaction
        \DB::beginTransaction();
        
        $user = User::create([
          'email' => $data['email'],
          'password' => bcrypt($data['password']),
          'firstname' => trim($data['firstname']) ?: null,
          'lastname' => trim($data['lastname']) ?: null,
        ]);
        
        $candidate = new Candidate();
        $candidate->user()->associate($user);
        
        // find or create the school
        $schoolId = trim($data['school'] ?? '');
        if ($schoolId) {
            $school = School::find($schoolId);
            if ($schoolId) {
                $candidate->school()->associate($school);
            }
        }
        
        // find or create the education level
        $educationId = isset($data['education']) ? $data['education'] : false;
        if ($educationId) {
            $education = Education::find($educationId);
            if ($education) {
                $education->save();
                $candidate->education()->associate($education);
            }
        }
        
        $candidate->save();
        
        // commit all to database
        \DB::commit();
        
        // Subscribe the user
        Newsletter::subscribeOrUpdate($user->email, ['MMERGE5' => $user->firstname, 'MMERGE4' => $user->lastname], 'subscribers');
          
        return $user;
    }
    
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        
        event(new Registered($user = $this->create($request->all())));
        
        $this->guard()->login($user);
        
        if ($request->wantsJson()) {
            $fractal = new Manager();
            $resource = new Item($user->fresh(), new UserTransformer());
    
            return response()->json(array_merge(
              $fractal->createData($resource)->toArray(),
              ['success' => true]
            ));
        } else {
            return redirect($this->redirectPath());
        }
    }
    
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
          'email' => 'required|email|max:255|unique:users',
          'password' => 'required|min:6',
        ]);
    }
}
