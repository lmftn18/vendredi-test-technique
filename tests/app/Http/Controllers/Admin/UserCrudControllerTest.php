<?php

namespace Tests\App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\UserCrudController;
use App\User;
use Faker\Factory;

class UserCrudControllerTest extends BaseCrudControllerTest
{
    private $user;

    public function setUp()
    {
        parent::setUp();

        $faker = Factory::create();

        $this->user = [
            'firstname' => $faker->word,
            'lastname' => $faker->word,
            'email' => $faker->email,
            'is_admin' => $faker->boolean,
            'password' => $faker->password(10)
        ];
    }

    /**
     * Test the list view is displayed ok.
     */
    public function testList()
    {
        $this->visit('/admin/user')
             ->see(UserCrudController::SINGLE_NAME);
    }

    /**
     * Test we can create a new entity.
     */
    public function testCreate()
    {
        $this->visit('/admin/user/create')
             ->submitForm($this->saveButtonText, $this->user)
            ->seePageIs('/admin/user')
        ;

        $user = $this->user;
        unset($user['password']);
        $this->seeInDatabase('users', $user);
    }

    /**
     * Test we can edit an entity.
     */
    public function testEdit()
    {
        $user = User::find(1);
        $oldPassword = $user->password;

        $this->visit('/admin/user/1/edit')
             ->submitForm($this->saveButtonText, $this->user)
             ->seePageIs('/admin/user')
        ;

        $user = $this->user;
        unset($user['password']);
        $this->seeInDatabase('users', $user);

        $newUser = User::find(1);
        $newPassword = $newUser->password;
        $this->assertNotEquals($newPassword, $oldPassword, 'the password has been changed');
    }

    /**
     * Test we can edit an entity.
     */
    public function testEditNoPasswordChange()
    {
        $user = User::find(1);
        $oldPassword = $user->password;

        $user = $this->user;
        unset($user['password']);

        $this->visit('/admin/user/1/edit')
             ->submitForm($this->saveButtonText, $user)
             ->seePageIs('/admin/user')
        ;

        $this->seeInDatabase('users', $user);

        $newUser = User::find(1);
        $newPassword = $newUser->password;
        $this->assertEquals($newPassword, $oldPassword, 'the password has been left unchanged');
    }

    /**
     * Test we get all error messages when we omit necessary parameters.
     */
    public function testEditMissingParameters()
    {
        $user = $this->user;
        $user['email'] = null;

        $this->visit('/admin/user/1/edit')
             ->submitForm($this->saveButtonText, $user)
             ->see($this->requiredFieldMessage('email'))
        ;
    }

    /**
     * Test we get all error messages when we omit necessary parameters for creation.
     */
    public function testCreateMissingParameters()
    {
        $user = $this->user;
        $user['email'] = null;
        $user['password'] = null;

        $this->visit('/admin/user/create')
             ->submitForm($this->saveButtonText, $user)
             ->see($this->requiredFieldMessage('email'))
             ->see($this->requiredFieldMessage('password'))
        ;
    }
}
