<?php
/**
 * Created by PhpStorm.
 * User: jguerin
 * Date: 04/03/2017
 * Time: 10:36
 */

namespace App\Http\Controllers;


use App\Education;
use App\School;
use App\Transformers\UserTransformer;
use App\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Newsletter;
use Validator;

class UserController extends Controller
{
    /**
     * Update current User
     *
     * @return JsonResponse
     */
    public function updateMe(Request $request)
    {
        $this->validate($request, [
          'firstname' => 'required|max:255',
          'lastname' => 'required|max:255',
          'email' => 'required|email',
          'password' => 'sometimes|min:6',
          'school' => 'exists:schools,id',
          'education' => 'exists:educations,id',
        ]);
        
        $me = \Auth::getUser();
        
        $emailAlreadyInDatabase = User::where([
            ['email', '=', $request->input('email')],
            ['id', '!=', $me->id]
          ])->count() != 0;
        
        
        if ($emailAlreadyInDatabase) {
            return response()->json(
              [
                'email' => [
                  'Email déjà utilisé'
                ]
              ],
              JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $me->firstname = $request->input('firstname');
        $me->lastname = $request->input('lastname');
        $me->email = $request->input('email');
        
        if ($request->input('password', false)) {
            $me->password = Hash::make($request->input('password'));
        }
        
        $school = School::find($request->input('school'));
        $me->candidate->school()->associate($school);
        
        $education = Education::find($request->input('education'));
        $me->candidate->education()->associate($education);
        
        if ($me->save() && $me->candidate->save()) {
            Newsletter::subscribeOrUpdate($me->email, ['MMERGE5' => $me->firstname, 'MMERGE4' => $me->lastname], 'subscribers');
            
            $fractal = new Manager();
            $resource = new Item($me->fresh(), new UserTransformer());
            
            return response()->json(array_merge(
              $fractal->createData($resource)->toArray(),
              ['success' => true]
            ));
        } else {
            return response()->json(
              ['success' => false],
              JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
        
        
    }
    
}