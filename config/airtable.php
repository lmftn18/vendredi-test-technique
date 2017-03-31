<?php

return [
    'enabled' => env('AIRTABLE_ENABLED', false),

    'url' => env('AIRTABLE_URL', null),
    'api_key' => env('AIRTABLE_APIKEY', null),

    'table_company' => env('AIRTABLE_COMPANY_TABLE', 'ENTREPRISES'),
    'table_job' => env('AIRTABLE_JOB_TABLE', 'OFFRES'),
    'table_association' => env('AIRTABLE_ASSOCIATION_TABLE', 'ASSO'),
    'table_mission' => env('AIRTABLE_MISSION_TABLE', 'MISSIONS'),
];