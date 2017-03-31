<?php

namespace App\Connectors;

use App\Connectors\AirTable\AssociationAirTable;
use App\Connectors\AirTable\CompanyAirTable;
use App\Connectors\AirTable\BaseConnector;
use App\Connectors\AirTable\ConnectorInterface;
use App\Connectors\AirTable\DummyConnector;
use App\Connectors\AirTable\JobAirTable;
use App\Connectors\AirTable\MissionAirTable;
use App\Exceptions\VendrediException;

class AirTable
{
    const COMPANY = 'company';
    const ASSOCIATION = 'association';
    const JOB = 'job';
    const MISSION = 'mission';

    /**
     * @param $connector
     *
     * @return ConnectorInterface
     * @throws VendrediException
     */
    public function get( $connector )
    {
        if ( ! \Config::get( 'airtable.enabled' ) ) {
            return new DummyConnector();
        }

        switch ( $connector ) {
            case null:
                return new DummyConnector();
            case static::COMPANY:
                return new CompanyAirTable();
            case static::ASSOCIATION:
                return new AssociationAirTable();
            case static::MISSION:
                return new MissionAirTable();
            case static::JOB:
                return new JobAirTable();
            default:
                throw new VendrediException( 'This connector is not implemented.' );
        }
    }
}