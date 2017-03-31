<?php

namespace App\Connectors\AirTable;

use App\AirtableModel;
use App\Exceptions\AirTableException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Class Connector
 * @package App\Connectors\AirTable
 *
 * Basic CRUD functions for AirTable connection
 */
abstract class BaseConnector implements ConnectorInterface
{
    protected $client;
    protected $url;

    protected abstract function getJsonArray( AirtableModel $model );

    public abstract function getAirTableId( AirtableModel $model );

    /** The message to show if we cannot find the AirTable ID */
    protected abstract function getAirTableIdExceptionMessage( AirtableModel $model );

    public function __construct()
    {
        // wrap Guzzle Client in order to throw an AirTableException instead of a ClientException on a request
        $this->client = new class
        {
            public $client;

            public function __construct()
            {
                $this->client = new Client( [
                    'headers' => [
                        'Authorization' => 'Bearer ' . \Config::get( 'airtable.api_key' ),
                        'Content-type'  => 'application/json',
                    ],
                ] );
            }

            public function request( $method, $uri = '', array $options = [] )
            {
                try {
                    return $this->client->request( $method, $uri, $options );
                } catch ( ClientException $e ) {
                    \AppHelper::addFlashMsg( 'error', $e->getMessage() );
                    throw new AirTableException( $e->getMessage() );
                }
            }
        };
    }

    public function create( AirtableModel $model )
    {
        $this->client->request(
            'POST',
            $this->url,
            [
                'json' => $this->getJsonArray( $model )
            ]
        );

        $model->airtable_state = AirtableModel::SYNCED;

        return true;
    }

    public function update( AirtableModel $model )
    {
        // update the record
        $this->client->request(
            'PATCH',
            $this->url . '/' . $this->getAirTableIdOrFail( $model ),
            [
                'json' => $this->getJsonArray( $model )
            ]
        );

        $model->airtable_state = AirtableModel::SYNCED;

        return true;
    }

    public function delete( AirtableModel $model )
    {
        $this->client->request( 'DELETE', $this->url . '/' . $this->getAirTableIdOrFail( $model ) );
    }

    public function sync( AirtableModel $model )
    {
        $airTableId = $this->getAirTableId( $model );
        if ( $airTableId ) {
            $this->update( $model );
        } else {
            $this->create( $model );
        }

        $model->airtable_state = AirtableModel::SYNCED;
        $model->save();

        return true;
    }

    public function getAirTableIdOrFail( AirtableModel $model )
    {
        $airTableId = $this->getAirTableId( $model );
        if ( ! $airTableId ) {
            throw new AirTableException($this->getAirTableIdExceptionMessage($model));
        }

        return $airTableId;
    }
}