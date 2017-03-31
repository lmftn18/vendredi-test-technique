<?php

namespace Tests\App\Http\Controllers\Admin;


use App\Helpers\AppStatic;
use App\Http\Controllers\Admin\EducationCrudController;
use Faker\Factory;

class EducationCrudControllerTest extends BaseCrudControllerTest
{
    private $education;

    public function setUp()
    {
        parent::setUp();

        $faker = Factory::create();

        $this->education = [
            'value' => $faker->word,
        ];
    }

    /**
     * Test the list view is displayed ok.
     */
    public function testList()
    {
        $this->visit('/admin/education')
             ->see(AppStatic::mb_ucfirst(EducationCrudController::PLURAL_NAME));
    }

    /**
     * Test we can create a new entity.
     */
    public function testCreate()
    {
        $this->visit('/admin/education/create')
             ->submitForm($this->saveButtonText, $this->education)
             ->seePageIs('/admin/education')
        ;

        $this->seeInDatabase('educations', $this->education);
    }

    /**
     * Test we can edit an entity.
     */
    public function testEdit()
    {
        $this->visit('/admin/education/1/edit')
             ->submitForm($this->saveButtonText, $this->education)
             ->seePageIs('/admin/education')
        ;

        $this->seeInDatabase('educations', $this->education);
    }

    /**
     * Test we get all error messages when we omit necessary parameters.
     */
    public function testEditMissingParameters()
    {
        $education = $this->education;
        $education['value'] = null;

        $this->visit('/admin/education/1/edit')
             ->submitForm($this->saveButtonText, $education)
             ->see($this->requiredFieldMessage(EducationCrudController::SINGLE_NAME))
        ;
    }
}
