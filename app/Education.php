<?php

namespace App;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use CrudTrait;

    // necessary for backpack, which has a hard time deducing this table's name...
    protected $table = 'educations';
    protected $guarded = [ 'id' ];

    public function candidate()
    {
        return $this->hasMany('App\Candidate');
    }
}
