<?php
/**
 * Created by PhpStorm.
 * User: jguerin
 * Date: 04/03/2017
 * Time: 11:51
 */

namespace App\Transformers;


use App\School;
use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user){
        return [
          'firstname' => $user->firstname,
          'lastname' => $user->lastname,
          'email' => $user->email,
          'created_at_timestamp' => $user->created_at->timestamp,
          'user_hash' => hash_hmac("sha256", $user->email, "ET-F17JC5ZOZUqRiR9Ju7TZvhVOnpW8DbFxsf1LX"),
          'school_id' => $user->candidate && $user->candidate->school ? $user->candidate->school->id : '',
          'school_name' => $user->candidate && $user->candidate->school ? $user->candidate->school->value : '',
          'education_id' => $user->candidate && $user->candidate->education ? $user->candidate->education->id : '',
        ];
    }
}