<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SchoolRequest as StoreRequest;
use App\Http\Requests\SchoolRequest as UpdateRequest;

class SchoolCrudController extends BaseCrudController
{
    const SINGLE_NAME = 'école';
    const PLURAL_NAME = 'écoles';

    public function setUp()
    {
        $valueLabel = $this->getUCTitle(static::SINGLE_NAME);
        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel('App\School');
        $this->crud->setRoute("admin/school");
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
                'name' => 'value',
                'label' => $valueLabel,
            ]
        ]);

        // ------ CRUD COLUMNS
        $this->crud->setColumnDetails('value', [
            'label' => $valueLabel
        ]);
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
