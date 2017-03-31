<?php

namespace App\Http\Controllers\Admin;

use App\CRUD\CrudPanel;
use App\Exceptions\ImportException;
use App\Helpers\AppStatic;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Backpack\CRUD\app\Http\Requests\CrudRequest as StoreRequest;
use Backpack\CRUD\app\Http\Requests\CrudRequest as UpdateRequest;

/**
 * Class BaseCrudController: base CRUD class we can extends for custom functions.
 *
 * @package App\Http\Controllers\Admin
 */
class BaseCrudController extends CrudController
{
    /** @var CrudPanel $crud */
    public $crud;
    const SINGLE_NAME = 'entité';
    const PLURAL_NAME = 'entités';

    /**
     * BaseCrudController constructor.
     *
     * Override the basic CrudController one to inject our extended CrudPanel.
     */
    public function __construct()
    {
        if ( ! $this->crud ) {
            $this->crud = new CrudPanel();

            // call the setup function inside this closure to also have the request there
            // this way, developers can use things stored in session (auth variables, etc)
            $this->middleware( function ( $request, $next ) {
                $this->request = $request;
                $this->crud->request = $request;
                $this->setup();

                return $next( $request );
            } );
        }
    }

    /**
     * Returns the title with its first letter uppercase.
     *
     * @param $title
     *
     * @return string
     */
    protected function getUCTitle( $title )
    {
        return AppStatic::mb_ucfirst( $title );
    }

    /**
     * handle the import request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import( Request $request )
    {
        $importfile = $request->file( 'import' );

        try {
            $rowCount = $this->crud->getImporter()->importFile( $importfile->openFile( 'r' ) );
        } catch ( ImportException $e ) {
            \AppHelper::addFlashMsg( 'errors-vendredi', $e->getMessage() );

            return redirect()->to( $this->crud->route );
        }
        \AppHelper::addFlashMsg( 'success-vendredi', $rowCount . ' lignes ont été importées !' );

        return redirect()->to( $this->crud->route );
    }

    /**
     * Sync the entity with AirTable
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function syncAirTable( $id )
    {
        $entry = $this->crud->getEntry( $id );
        \AirTable::get( $this->crud->getAirTableSync() )->sync( $entry );

        // show a success message
        \Alert::success( trans( 'backpack::crud.update_success' ) )->flash();

        return redirect()->to( $this->crud->route );
    }

    /**
     * Updates the entity in the database and sync it with AirTable.
     *
     * @param UpdateRequest $request
     *
     * @return RedirectResponse
     */
    public function updateCrud( UpdateRequest $request = null )
    {
        $isSyncingAirTable = $this->crud->getAirTableSync() !== null;
        if ( ! $isSyncingAirTable ) {
            return parent::updateCrud( $request );
        }

        // sync with AirTable and save
        \DB::beginTransaction();
        $redirect_location = $this->updateCrudNoFlash( $request );
        \AirTable::get( $this->crud->getAirTableSync() )->update( $this->crud->entry );
        \DB::commit();

        // show a success message
        \Alert::success( trans( 'backpack::crud.update_success' ) )->flash();

        return $redirect_location;
    }

    /**
     * Insert the entity in the database and sync it with AirTable.
     *
     * @param StoreRequest $request
     *
     * @return RedirectResponse
     */
    public function storeCrud( StoreRequest $request = null )
    {
        $isSyncingAirTable = $this->crud->getAirTableSync() !== null;
        if ( ! $isSyncingAirTable ) {
            return parent::storeCrud( $request );
        }

        // sync with AirTable and save
        \DB::beginTransaction();
        $redirect_location = $this->storeCrudNoFlash( $request );
        \AirTable::get( $this->crud->getAirTableSync() )->create( $this->crud->entry );
        \DB::commit();

        // show a success message
        \Alert::success( trans( 'backpack::crud.insert_success' ) )->flash();

        return $redirect_location;
    }

    /**
     * Store a newly created resource in the database, WITHOUT FLASHING a success yet.
     *
     * @param StoreRequest $request - type injection used for validation using Requests
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function storeCrudNoFlash( StoreRequest $request = null )
    {
        $this->crud->hasAccessOrFail( 'create' );

        // fallback to global request instance
        if ( is_null( $request ) ) {
            $request = \Request::instance();
        }

        // replace empty values with NULL, so that it will work with MySQL strict mode on
        foreach ( $request->input() as $key => $value ) {
            if ( empty( $value ) && $value !== '0' ) {
                $request->request->set( $key, null );
            }
        }

        // insert item in the db
        $item = $this->crud->create( $request->except( ['save_action', '_token', '_method'] ) );
        $this->data['entry'] = $this->crud->entry = $item;

        // save the redirect choice for next time
        $this->setSaveAction();

        return $this->performSaveAction($item->getKey());
    }

    /**
     * Update the specified resource in the database, WITHOUT FLASHING a success yet.
     *
     * @param UpdateRequest $request - type injection used for validation using Requests
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function updateCrudNoFlash( UpdateRequest $request = null )
    {
        $this->crud->hasAccessOrFail( 'update' );

        // fallback to global request instance
        if ( is_null( $request ) ) {
            $request = \Request::instance();
        }

        // replace empty values with NULL, so that it will work with MySQL strict mode on
        foreach ( $request->input() as $key => $value ) {
            if ( empty( $value ) && $value !== '0' ) {
                $request->request->set( $key, null );
            }
        }

        // update the row in the db
        $item = $this->crud->update( $request->get( $this->crud->model->getKeyName() ),
            $request->except( 'save_action', '_token', '_method' ) );
        $this->data['entry'] = $this->crud->entry = $item;

        // save the redirect choice for next time
        $this->setSaveAction();

        return $this->performSaveAction();
    }

    /**
     * Remove the entity in the database and sync it with AirTable.
     *
     * @param $id
     *
     * @return string
     */
    public function destroy( $id )
    {
        $isSyncingAirTable = $this->crud->getAirTableSync() !== null;
        if ( ! $isSyncingAirTable ) {
            return parent::destroy( $id );
        }

        $entity = $this->crud->model->findOrFail( $id );

        // sync with AirTable and save
        \DB::beginTransaction();
        \AirTable::get( $this->crud->getAirTableSync() )->delete( $entity );
        $result = parent::destroy( $id );
        \DB::commit();

        return $result;
    }

    /**
     * Overrides the default saveReorder: we don't need depth, so we only want the order integer.
     * Comes from http://stackoverflow.com/a/40361674/2258657
     *
     * @return bool|string
     */
    public function saveReorder()
    {
        $this->crud->hasAccessOrFail( 'reorder' );

        $all_entries = \Request::input( 'tree' );

        if ( count( $all_entries ) ) {
            $count = 0;

            foreach ( $all_entries as $key => $entry ) {
                if ( $entry['item_id'] != '' && $entry['item_id'] != null ) {
                    $item = $this->crud->model->find( $entry['item_id'] );
                    $item->order = empty( $entry['left'] ) ? null : $entry['left'];
                    $item->save();

                    $count ++;
                }
            }
        } else {
            return false;
        }

        return 'success for ' . $count . ' items';
    }

    /**
     * Handle publish/unpublish of the entity and redirect to previous page.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function publish( Request $request )
    {
        $id = $request->request->get( 'id', null );
        $entity = $this->crud->model->findOrFail( $id );

        \DB::beginTransaction();
        $isPublished = ( 'true' === $request->request->get( 'isOn', 'false' ) );
        $entity->is_published = $isPublished;
        $entity->save();

        $isSyncingAirTable = $this->crud->getAirTableSync() !== null;
        if ( $isSyncingAirTable ) {
            \AirTable::get( $this->crud->getAirTableSync() )->update( $entity );
        }
        \DB::commit();

        return \Redirect::back();
    }
}