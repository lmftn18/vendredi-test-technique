<?php

namespace App\Connectors\AirTable;

use App\AirtableModel;

/**
 * Interface ConnectorInterface
 * @package App\Connectors\AirTable
 */
interface ConnectorInterface
{
    public function create( AirtableModel $model );

    public function update( AirtableModel $model );

    public function delete( AirtableModel $model );

    public function sync( AirtableModel $model );
}