<?php

namespace App\Http\Controllers\Admin;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Candidate;
use App\Education;
use App\Http\Requests\CandidateRequest as StoreRequest;
use App\Http\Requests\CandidateRequest as UpdateRequest;
use App\School;
use App\User;

class CandidateCrudController extends BaseCrudController
{
    const SINGLE_NAME = 'candidat';
    const PLURAL_NAME = 'candidats';

    public function setUp()
    {
        $userLabel = $this->getUCTitle(UserCrudController::SINGLE_NAME);
        $schoolLabel = $this->getUCTitle(SchoolCrudController::SINGLE_NAME);
        $educationLabel = $this->getUCTitle(EducationCrudController::SINGLE_NAME);
        $registrationDateLabel = "Date d'inscription";
        $isRecruitedLabel = 'Est recruté?';

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel('App\Candidate');
        $this->crud->setRoute("admin/candidate");
        $this->crud->setEntityNameStrings(static::SINGLE_NAME, static::PLURAL_NAME);

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

        $this->crud->setFromDb();

        // ------ CRUD FIELDS
        $this->crud->addFields([
            [
                'label' => $userLabel,
                'type' => 'select2',
                'name' => 'user_id', // the db column for the foreign key
                'entity' => 'user', // the method that defines the relationship in your Model
                'attribute' => 'email', // foreign key attribute that is shown to user
                'model' => 'App\User' // foreign key model
            ],
            [
                'label' => $schoolLabel,
                'type' => 'select2',
                'name' => 'school_id', // the db column for the foreign key
                'entity' => 'school', // the method that defines the relationship in your Model
                'attribute' => 'value', // foreign key attribute that is shown to user
                'model' => 'App\School' // foreign key model
            ],
            [
                'label' => $educationLabel,
                'type' => 'select2',
                'name' => 'education_id', // the db column for the foreign key
                'entity' => 'education', // the method that defines the relationship in your Model
                'attribute' => 'value', // foreign key attribute that is shown to user
                'model' => 'App\Education' // foreign key model
            ],
            [
                'name' => 'registration_date',
                'label' => $registrationDateLabel
            ],
            [
                'name' => 'is_recruited',
                'label' => $isRecruitedLabel,
                'type' => 'checkbox'
            ],
        ]);

        // ------ CRUD COLUMNS
        $this->crud->setColumnDetails('user_id', [
            // 1-n relationship
            'label' => 'Email utilisateur', // Table column heading
            'type' => "select",
            'name' => 'user_id', // the column that contains the ID of that connected entity;
            'entity' => 'user', // the method that defines the relationship in your Model
            'attribute' => "email", // foreign key attribute that is shown to user
            'model' => 'App\User', // foreign key model
        ]);
        $this->crud->addColumn('user_desc');
        $this->crud->setColumnDetails('user_desc', [
            // 1-n relationship
            'label' => $userLabel, // Table column heading
            'type' => "select",
            'name' => 'user_id', // the column that contains the ID of that connected entity;
            'entity' => 'user', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => 'App\User', // foreign key model
        ]);
        $this->crud->setColumnDetails('school_id', [
            // 1-n relationship
            'label' => $schoolLabel, // Table column heading
            'type' => "select",
            'name' => 'school_id', // the column that contains the ID of that connected entity;
            'entity' => 'school', // the method that defines the relationship in your Model
            'attribute' => "value", // foreign key attribute that is shown to user
            'model' => 'App\School', // foreign key model
        ]);
        $this->crud->setColumnDetails('education_id', [
            // 1-n relationship
            'label' => $educationLabel, // Table column heading
            'type' => "select",
            'name' => 'education_id', // the column that contains the ID of that connected entity;
            'entity' => 'education', // the method that defines the relationship in your Model
            'attribute' => "value", // foreign key attribute that is shown to user
            'model' => 'App\Education', // foreign key model
        ]);
        $this->crud->setColumnDetails('registration_date', [
            'label' => $registrationDateLabel,
        ]);
        $this->crud->setColumnDetails('is_recruited', [
            'label' => $isRecruitedLabel,
            'type' => 'check'
        ]);

        $this->crud->orderBy('registration_date', 'desc');
    }

	public function store(StoreRequest $request)
	{
		// your additional operations before save here
        $redirect_location = parent::storeCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
	}

	public function update(UpdateRequest $request)
	{
		// your additional operations before save here
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
	}
}
