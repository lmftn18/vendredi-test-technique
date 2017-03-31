<?php

namespace Tests\App\Http\Auth;


use App\Candidate;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{

    /**
     * Overrides to disable auth
     */
    public function setUp()
    {
        parent::setUpWithoutLogin();
    }

    public function testSuccessResponseWithJSON()
    {


        $user = Candidate::first()->user;
        $user->password = bcrypt('123456');
        $user->save();
        $user->fresh();

        $parameters = [
          'email' => $user->email,
          'password' => '123456',
        ];

        $headers = [
          'Accept' => 'application/json',
        ];

        $this->post(route('candidate_login'), $parameters, $headers);

        $this->assertResponseOk()->seeJson(
          [
            'success' => true,
            'data' => [
              'firstname' => $user->firstname,
              'lastname' => $user->lastname,
              'email' => $user->email,
              'created_at_timestamp' => $user->created_at->timestamp,
              'user_hash' => hash_hmac("sha256", $user->email, "ET-F17JC5ZOZUqRiR9Ju7TZvhVOnpW8DbFxsf1LX"),
              'education_id' => $user->candidate->education ?  $user->candidate->education->id : '',
              'school_id' => $user->candidate->school ?  $user->candidate->school->id : '',
              'school_name' =>  $user->candidate->school ? $user->candidate->school->value : '',
            ]
          ]
        );
    }

    public function testErrorResponseWithJSON()
    {


        $user = Candidate::first()->user;
        $user->password = bcrypt('123456');
        $user->save();

        $parameters = [
          'email' => $user->email,
          'password' => 'aaaaaa',
        ];

        $headers = [
          'Accept' => 'application/json',
        ];

        $this->post(route('candidate_login'), $parameters, $headers);

        $this->assertResponseOk()
          ->seeJson(['success' => false]);
    }
}