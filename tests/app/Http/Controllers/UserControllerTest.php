<?php

namespace Tests;


use App\Education;
use App\School;
use App\User;

/**
 * @property User user
 * @property array candidateAttributes
 * @property array userAttributes
 */
class UserControllerTest extends TestCase
{
    /**
     *
     */
    public function setUp()
    {
        parent::setUpWithoutLogin();

        $this->user = factory(User::class)->create();

        $this->user->candidate()->create([
          'school_id' => School::first()->id,
          'education_id' => Education::first()->id,
          'registration_date' => date('Y-m-d'),
          'is_recruited' => false
        ]);

        $this->user->fresh();
        $this->be($this->user);

        $this->userAttributes = $this->user->attributesToArray();
        unset($this->userAttributes['updated_at']);
        $this->candidateAttributes = $this->user->candidate->attributesToArray();
        unset($this->candidateAttributes['updated_at']);


    }
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

    private function assertUserInfoChangedProperly(array $userArray, array $candidateArray, $password = false)
    {
        $parameters = $this->getAttributesAsFormParameters($userArray, $candidateArray);

        if($password){
            $parameters['password'] = $password;
        }
        $headers = [
          'Accept' => 'application/json',
        ];
        $this->mockNewsletterExpecting([ $userArray['email'],  ['MMERGE5' => $userArray['firstname'], 'MMERGE4' => $userArray['lastname']], 'subscribers']);
        $response = $this->put(route('candidate_update_me'), $parameters, $headers)
          ->seeStatusCode(200)
          ->seeJsonStructure(
            [
              'success',
              'data' => [
                'firstname',
                'lastname',
                'email',
                'school_id',
                'school_name',
                'education_id',
                'user_hash',
                'created_at_timestamp'
              ]
            ]
          );

        $this->seeInDatabase('users', $userArray);
        $this->seeInDatabase('candidates', $candidateArray);

    }

    /**
     * @param array $userArray
     * @param array $candidateArray
     * @return \Illuminate\Http\Response
     */
    private function assertUserInfoChangeBadRequest(array $userArray, array $candidateArray, $password = false)
    {
        $parameters = $this->getAttributesAsFormParameters($userArray, $candidateArray);

        if($password){
            $parameters['password'] = $password;
        }

        $headers = [
          'Accept' => 'application/json',
        ];

        return  $this->put(route('candidate_update_me'), $parameters, $headers)
          ->seeStatusCode(422)->response;
    }

    private function getAttributesAsFormParameters(array $userArray, array $candidateArray)
    {
        return [
          'firstname' => $userArray['firstname'],
          'lastname' => $userArray['lastname'],
          'email' => $userArray['email'],
          'school' => $candidateArray['school_id'],
          'education' => $candidateArray['education_id'],
        ];
    }

    /*
     *
     * General USER attributes
     *
     *
     */

    public function testChangeUserFirstname()
    {
        $this->userAttributes['firstname'] = str_random(8);
        $this->assertUserInfoChangedProperly($this->userAttributes, $this->candidateAttributes);
    }

    public function testChangeUserLastname()
    {
        $this->userAttributes['lastname'] = str_random(8);
        $this->assertUserInfoChangedProperly($this->userAttributes, $this->candidateAttributes);
    }

    public function testChangeUserEmailWithNewOne()
    {
        $this->userAttributes['lastname'] = str_random(8);
        $this->assertUserInfoChangedProperly($this->userAttributes, $this->candidateAttributes);
    }

    public function testErrorOnChangeUserEmailWithExistingOne()
    {
        $this->userAttributes['email'] = User::where('email', '!=', $this->user->email)->first()->email;
        $this->assertUserInfoChangeBadRequest($this->userAttributes, $this->candidateAttributes);
        $this->seeJsonStructure(['email']);
    }

    public function testChangeUserPassword()
    {
        $password = str_random(8);

        $this->assertUserInfoChangedProperly($this->userAttributes, $this->candidateAttributes, $password);

        $this->user->fresh();

        $this->assertTrue(\Hash::check($password, $this->user->password));
    }

    public function testErrorChangeUserPasswordTooShort()
    {
        $password = str_random(5);

        $this->assertUserInfoChangeBadRequest($this->userAttributes, $this->candidateAttributes, $password);

    }

    /*
     *
     * General CANDIDATE attributes
     *
     *
     */

    public function testChangeUserEducation()
    {
        $this->candidateAttributes['education_id'] = Education::where('id', '!=', $this->user->candidate->education_id)->first()->id;
        $this->assertUserInfoChangedProperly($this->userAttributes, $this->candidateAttributes);
    }

    public function testErrorOnChangeEducationDoesNotExist()
    {
        $this->candidateAttributes['education_id'] = Education::max('id') + 1000 ;
        $this->assertUserInfoChangeBadRequest($this->userAttributes, $this->candidateAttributes);
        $this->seeJsonStructure(['education']);
    }

    public function testChangeUserSchool()
    {
        $this->candidateAttributes['school_id'] = School::where('id', '!=', $this->user->candidate->school_id)->first()->id;
        $this->assertUserInfoChangedProperly($this->userAttributes, $this->candidateAttributes);
    }

    public function testErrorOnChangeSchoolDoesNotExist()
    {
        $this->candidateAttributes['school_id'] = School::max('id') + 1000 ;
        $this->assertUserInfoChangeBadRequest($this->userAttributes, $this->candidateAttributes);
        $this->seeJsonStructure(['school']);
    }
}