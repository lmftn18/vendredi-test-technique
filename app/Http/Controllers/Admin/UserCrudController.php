<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\UserStoreRequest as StoreRequest;
use App\Http\Requests\UserUpdateRequest as UpdateRequest;

class UserCrudController extends CrudController
{
    const SINGLE_NAME = 'utilisateur';
    const PLURAL_NAME = 'utilisateurs';

    public function setUp()
    {
        $firstnameLabel = 'Prénom';
        $lastnameLabel = 'Nom de famille';
        $emailLabel = 'Email';
        $passwordLabel = 'Mot de passe';
        $isAdminLabel = 'Est admin?';

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel('App\User');
        $this->crud->setRoute("admin/user");
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
                'name' => 'firstname',
                'label' => $firstnameLabel,
            ],
            [
                'name' => 'lastname',
                'label' => $lastnameLabel,
            ],
            [
                'name' => 'email',
                'label' => $emailLabel,
            ],
            [
                'name' => 'password',
                'label' => $passwordLabel,
            ],
            [
                'name' => 'is_admin',
                'label' => $isAdminLabel,
                'type' => 'checkbox'
            ],
        ]);

        // ------ CRUD COLUMNS
        $this->crud->setColumnDetails('firstname', [
            'label' => $firstnameLabel,
        ]);
        $this->crud->setColumnDetails('lastname', [
            'label' => $lastnameLabel,
        ]);
        $this->crud->setColumnDetails('email', [
            'label' => $emailLabel,
        ]);
        $this->crud->setColumnDetails('is_admin', [
            'label' => $isAdminLabel,
            'type' => 'check'
        ]);
    }

	public function store(StoreRequest $request)
	{
	    // encrypt password
	    $password = $request->request->get('password', null);
        if ($password === '' || $password === null) {
            $request->request->remove( 'password' );
        } else {
            $request->request->set( 'password', bcrypt( $password ) );
        }

		// your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
	}

	public function update(UpdateRequest $request)
	{
        // encrypt password, only if it not empty
        $password = $request->request->get('password', null);
        if ($password !== '' && $password !== null) {
            $password = bcrypt($password);
            $request->request->set('password', $password);
        }
        else {
            $request->request->remove('password');
        }

		// your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
	}
}
