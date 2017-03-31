<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AirtableModel extends Model
{
    const SYNCED = 'synced';
    const SYNCING = 'syncing';
    const UNSYNCED = 'unsynced';

    public function getIsSyncedWithAirTableAttribute()
    {
        return $this->airTableState === static::SYNCED;
    }
}