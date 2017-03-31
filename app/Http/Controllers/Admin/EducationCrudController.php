<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AppStatic;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\EducationRequest as StoreRequest;
use App\Http\Requests\EducationRequest as UpdateRequest;

class EducationCrudController extends CrudController
{
    const SINGLE_NAME = 'niveau';
    const PLURAL_NAME = 'niveaux';

    public function setUp()
    {
        $valueLabel = AppStatic::mb_ucfirst(static::SINGLE_NAME);

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel('App\Education');
        $this->crud->setRoute("admin/education");
        $this->crud->setEntityNameStrings(static::SINGLE_NAME, static::PLURAL_NAME);

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

        // ------ CRUD FIELDS
         $this->crud->addFields([
             [
                 'name' => 'value',
                 'label' => $valueLabel,
             ]
         ]);

        // ------ CRUD COLUMNS
        $this->crud->addColumn('value');
        $this->crud->setColumnDetails('value', [
            'label' => $valueLabel
        ]);

        $this->crud->enableReorder('value', 1);
        $this->crud->allowAccess('reorder');

        $this->crud->orderBy('order');
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
