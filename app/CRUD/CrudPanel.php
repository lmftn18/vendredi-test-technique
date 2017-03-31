<?php

namespace App\CRUD;

use App\Exceptions\VendrediException;
use App\Importers\Importer\BaseImporter;
use Backpack\CRUD\CrudPanel as BaseCrudPanel;
use Backpack\CRUD\PanelTraits\CrudFilter;

class CrudPanel extends BaseCrudPanel
{
    /** @var array $loadedColumns : set of loadedColumn. The columns types are the keys. */
    private $loadedColumns = [];

    /** @var $airTableSync : name of the airTable connector to be used. Leave null if no sync to be done. */
    public $airTableSync = null;

    /** @var $importerName : name of the importer to be used. Leave null if no import to be done. */
    private $importerName;

    /**
     * Check if field is the first of its type in the given fields iterable.
     * It's used in each field_type.blade.php to determine wether to push the css and js content or not (we only need to push the js and css for a field the first time it's loaded in the form, not any subsequent times).
     *
     * @param array $filter The current field being tested if it's the first of its type.
     * @param array $filters_array All the fields in that particular form.
     *
     * @return bool true/false
     */
    public function checkIfFilterIsFirstOfItsType( $filter, $filters_array )
    {
        $firstFilter = $this->getFirstOfItsTypeInIterable( $filter->type, $filters_array );

        $isNotFirstFilter = (
            ! $firstFilter
            || $filter->name != $firstFilter->name
        );

        return $isNotFirstFilter;
    }

    /**
     * Return the first element in an iterable that has the given 'type' attribute.
     *
     * @param string $type
     * @param array  $array
     *
     * @return array
     */
    public function getFirstOfItsTypeInIterable( $type, $array )
    {
        foreach ( $array as $item ) {
            if ( $item->type === $type ) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Check whether this type of column has been displayed at least once (useful to avoid requiring scripts more than
     * once).
     *
     * @param $columnType
     *
     * @return bool
     */
    public function isColumnAlreadyLoaded( $columnType )
    {
        return in_array( $columnType, array_keys( $this->loadedColumns ) );
    }

    /**
     * Adds a column type to the loadedColumn set.
     *
     * @param $columnType
     */
    public function addToLoadedColumns( $columnType )
    {
        $this->loadedColumns += [ $columnType => 1 ];
    }

    /**
     * Adds an orderByRaw to the query builder.
     *
     * @param $raw
     */
    public function orderByRaw( $raw )
    {
        $this->query->orderByRaw( $raw );
    }

    /**
     * Set to the airtable connector name to enable sync.
     *
     * @param $airtableName
     */
    public function enableAirTableSync( $airtableName )
    {
        $this->airTableSync = $airtableName;
        $this->addButtonFromView( 'line', 'syncairTable', 'sync-airtable', 'beginning');
    }

    /**
     * Get the airtable connector name - null if no sync.
     *
     * @return string
     */
    public function getAirTableSync()
    {
        return $this->airTableSync;
    }

    /**
     * Set to the importer name to enable import.
     *
     * @param $importerName
     */
    public function enableImporter( $importerName )
    {
        $this->importerName = $importerName;
        $this->addButtonFromView( 'top', 'import', 'import', 'end' );
    }

    /**
     * Get the importer - dummy if no import.
     *
     * @return BaseImporter
     */
    public function getImporter()
    {
        return \Importer::get( $this->importerName );
    }
}