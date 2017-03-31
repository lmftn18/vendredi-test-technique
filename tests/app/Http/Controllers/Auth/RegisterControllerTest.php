<?php

namespace Tests\App\Http\Auth;


use App\School;
use App\User;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{

    private function mockNewsletterExpecting($args){
        \Newsletter::shouldReceive('subscribeOrUpdate')
          ->withArgs($args)
          ->once()
          ->andReturnUsing(function () {
              $m = new \Mockery\Mock();
              $m->shouldReceive('sendTemplate');
              return $m;
          });
    }
    /**
     * Overrides to disable auth
     */
    public function setUp()
    {
        parent::setUpWithoutLogin();

    }



    public function testSuccessResponseWithJSON()
    {


        $user = factory(User::class)->make();
        $school = factory(School::class)->create();

        $parameters = [
          'email' => $user->email,
          'password' => '123456',
          'firstname' => $user->firstname,
          'lastname' => $user->lastname,
          'education' => '',
          'school' => $school->id,
        ];

        $this->mockNewsletterExpecting([
          $user->email,
          ['MMERGE5' => $user->firstname, 'MMERGE4' => $user->lastname],
          'subscribers'
        ]);

        $headers = [
          'Accept' => 'application/json',
        ];

        $this->post(route('candidate_register'), $parameters, $headers);

        $rawContent = $this->assertResponseOk()->response->getContent();

        $jsonContent = json_decode($rawContent, true);

        $registeredUser = \App\User::where('email', $user->email)->first();

        $this->assertEquals([
          'success' => true,
          'data' => [
            'firstname' => $registeredUser->firstname,
            'lastname' => $registeredUser->lastname,
            'email' => $registeredUser->email,
            'created_at_timestamp' => $registeredUser->created_at->timestamp,
            'user_hash' => hash_hmac("sha256", $registeredUser->email, "ET-F17JC5ZOZUqRiR9Ju7TZvhVOnpW8DbFxsf1LX"),
            'education_id' => $registeredUser->candidate->education ?  $registeredUser->candidate->education->id : '',
            'school_id' => $registeredUser->candidate->school->id,
            'school_name' => $registeredUser->candidate->school->value,
          ]
        ], $jsonContent, 'we return the correct data');
    }

    public function testSuccessResponseViaLinkedin() {

        $user = factory(User::class)->make();

        $linkedinResponse = [
          'emailAddress' => $user->email,
          'firstName' => $user->firstname,
          'lastName' => $user->lastname,
        ];

        \LinkedIn::shouldReceive('isAuthenticated')
          ->withNoArgs()
          ->andReturn(true);
        \LinkedIn::shouldReceive('get')
          ->with('v1/people/~:(firstName,lastName,emailAddress)')
          ->andReturn($linkedinResponse);

        $redirectUrl = route('home');
        $encrypted = encrypt(str_random(5) . '#' . $redirectUrl);

        $parameters = [
         'state' => $encrypted
        ];

        $this->mockNewsletterExpecting([
          $user->email,
          ['MMERGE5' => $user->firstname, 'MMERGE4' => $user->lastname],
          'subscribers'
        ]);

        $this->get(route('candidate_login_linkedin', $parameters))->seeStatusCode(200);
    }

    public function testNewsletterIsCalledEvenWithExistingUsers() {

        $user = factory(User::class)->create();

        $linkedinResponse = [
          'emailAddress' => $user->email,
          'firstName' => $user->firstname,
          'lastName' => $user->lastname,
        ];

        \LinkedIn::shouldReceive('isAuthenticated')
          ->withNoArgs()
          ->andReturn(true);
        \LinkedIn::shouldReceive('get')
          ->with('v1/people/~:(firstName,lastName,emailAddress)')
          ->andReturn($linkedinResponse);

        $redirectUrl = route('home');
        $encrypted = encrypt(str_random(5) . '#' . $redirectUrl);

        $parameters = [
          'state' => $encrypted
        ];

        $this->mockNewsletterExpecting([
          $user->email,
          ['MMERGE5' => $user->firstname, 'MMERGE4' => $user->lastname],
          'subscribers'
        ]);

        $this->get(route('candidate_login_linkedin', $parameters))->seeStatusCode(200);
    }

    public function testErrorIfExisitingEmail()
    {

        $user = factory(User::class)->create();

        $parameters = [
          'email' => $user->email,
          'password' => '123456',
          'firstname' => $user->firstname,
          'lastname' => $user->lastname,
          'education' => '',
          'school' => '',
        ];

        $headers = [
          'Accept' => 'application/json',
        ];

        $this->post(route('candidate_register'), $parameters, $headers);

        $this->assertResponseStatus(422)
          ->seeJsonStructure(['email']);
    }

    public function testErrorResponseWithJSON()
    {


        $parameters = [
          'email' => 'notanemail',
          'password' => '1236',
          'firstname' => '',
          'lastname' => '',
          'education' => '',
          'school' => '',
        ];

        $headers = [
          'Accept' => 'application/json',
        ];
        $this->post(route('candidate_register'), $parameters, $headers);

        $this->assertResponseStatus(422)
          ->seeJsonStructure(['email', 'password']);
    }
}