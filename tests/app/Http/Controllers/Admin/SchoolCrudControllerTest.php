<?php

namespace Tests\App\Http\Controllers\Admin;


use App\Http\Controllers\Admin\SchoolCrudController;
use Faker\Factory;

class SchoolCrudControllerTest extends BaseCrudControllerTest
{
    private $school;

    public function setUp()
    {
        parent::setUp();

        $faker = Factory::create();

        $this->school = [
            'value' => $faker->word,
        ];
    }

    /**
     * Test the list view is displayed ok.
     */
    public function testList()
    {
        $this->visit('/admin/school')
             ->see(SchoolCrudController::SINGLE_NAME);
    }

    /**
     * Test we can create a new entity.
     */
    public function testCreate()
    {
        $this->visit('/admin/school/create')
             ->submitForm($this->saveButtonText, $this->school)
             ->seePageIs('/admin/school')
        ;

        $this->seeInDatabase('schools', $this->school);
    }

    /**
     * Test we can edit an entity.
     */
    public function testEdit()
    {
        $this->visit('/admin/school/1/edit')
             ->submitForm($this->saveButtonText, $this->school)
             ->seePageIs('/admin/school')
        ;

        $this->seeInDatabase('schools', $this->school);
    }

    /**
     * Test we get all error messages when we omit necessary parameters.
     */
    public function testEditMissingParameters()
    {
        $school = $this->school;
        $school['value'] = null;

        $this->visit('/admin/school/1/edit')
             ->submitForm($this->saveButtonText, $school)
             ->see($this->requiredFieldMessage(SchoolCrudController::SINGLE_NAME))
        ;
    }
}
