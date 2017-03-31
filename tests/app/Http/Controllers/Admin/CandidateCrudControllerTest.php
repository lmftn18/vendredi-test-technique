<?php

namespace Tests\App\Http\Controllers\Admin;

use App\Education;
use App\Http\Controllers\Admin\CandidateCrudController;
use App\Http\Controllers\Admin\EducationCrudController;
use App\Http\Controllers\Admin\SchoolCrudController;
use App\School;
use App\User;
use Faker\Factory;

class CandidateCrudControllerTest extends BaseCrudControllerTest
{
    private $candidate;

    public function setUp()
    {
        parent::setUp();

        $faker = Factory::create();

        $this->candidate = [
            'registration_date' => $faker->dateTimeBetween('- 1 year', '+ 1 year')->format('Y-m-d H:i:s'),
            'is_recruited' => true,
            'education_id' => Education::first()->id,
            'school_id' => School::first()->id,
            'user_id' => User::first()->id,
        ];
    }

    /**
     * Test the list view is displayed ok.
     */
    public function testList()
    {
        $this->visit('/admin/candidate')
             ->see(CandidateCrudController::SINGLE_NAME);
    }

    /**
     * Test we can create a new entity.
     */
    public function testCreate()
    {
        $this->visit('/admin/candidate/create')
             ->submitForm($this->saveButtonText, $this->candidate)
             ->seePageIs('/admin/candidate')
        ;

        $this->seeInDatabase('candidates', $this->candidate);
    }

    /**
     * Test we can edit an entity.
     */
    public function testEdit()
    {
        $this->visit('/admin/candidate/1/edit')
             ->submitForm($this->saveButtonText, $this->candidate)
             ->seePageIs('/admin/candidate')
        ;

        $this->seeInDatabase('candidates', $this->candidate);
    }

    /**
     * Test we get all error messages when we omit necessary parameters for creation.
     */
    public function testCreateMissingParameters()
    {
        $candidate = $this->candidate;
        $candidate['school_id'] = null;
        $candidate['education_id'] = null;

        $this->visit('/admin/candidate/create')
             ->submitForm($this->saveButtonText, $candidate)
             ->see($this->requiredFieldMessage(SchoolCrudController::SINGLE_NAME))
             ->see($this->requiredFieldMessage(EducationCrudController::SINGLE_NAME))
        ;
    }
}
