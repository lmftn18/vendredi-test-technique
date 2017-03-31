<?php

namespace App;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use CrudTrait;

    protected $guarded = [ 'id' ];

    public function user()
    {
        return $this->belongsTo( 'App\User' );
    }

    public function education()
    {
        return $this->belongsTo( 'App\Education' );
    }

    public function school()
    {
        return $this->belongsTo( 'App\School' );
    }

    public function applications()
    {
        return $this->hasMany( 'App\Application' );
    }

    public function getIdentityAttribute()
    {
        return $this->user->firstname . ' ' . $this->user->lastname . ' (' . $this->user->email . ')';
    }

    public function getFirstnameAttribute()
    {
        return $this->user->firstname;
    }

    public function getLastnameAttribute()
    {
        return $this->user->lastname;
    }

    public function getEmailAttribute()
    {
        return $this->user->email;
    }
}
