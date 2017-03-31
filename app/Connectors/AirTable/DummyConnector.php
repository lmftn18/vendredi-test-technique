<?php

namespace App\Connectors\AirTable;

use App\AirtableModel;

/**
 * Class DummyConnector
 * @package App\Connectors\AirTable
 *
 * A dummy connector, to be used when we deactivate AirTable
 */
class DummyConnector implements ConnectorInterface
{
    public function create( AirtableModel $model ) {}

    public function update( AirtableModel $model ) {}

    public function delete( AirtableModel $model ) {}

    public function sync( AirtableModel $model ) {}
}