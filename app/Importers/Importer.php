<?php

namespace App\Importers;

use App\Exceptions\VendrediException;
use App\Importers\Importer\AssociationImporter;
use App\Importers\Importer\BaseImporter;
use App\Importers\Importer\CompanyImporter;
use App\Importers\Importer\DummyImporter;
use App\Importers\Importer\JobImporter;
use App\Importers\Importer\MissionImporter;

class Importer
{
    const COMPANY = 'company';
    const ASSOCIATION = 'association';
    const JOB = 'job';
    const MISSION = 'mission';

    /**
     * @param $importer
     *
     * @return BaseImporter
     * @throws VendrediException
     */
    public function get( $importer )
    {
        switch ( $importer ) {
            case null:
                return new DummyImporter();
            case static::ASSOCIATION:
                return new AssociationImporter();
            case static::COMPANY:
                return new CompanyImporter();
            case static::JOB:
                return new JobImporter();
            case static::MISSION:
                return new MissionImporter();
            default:
                throw new VendrediException( "This importer $importer is not implemented." );
        }
    }
}