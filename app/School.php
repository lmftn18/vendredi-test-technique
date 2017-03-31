<?php

namespace App;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use CrudTrait;

    protected $guarded = [ 'id' ];

    public function candidates()
    {
        return $this->hasMany('App\Candidate');
    }
}
