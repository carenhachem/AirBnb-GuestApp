<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class policy extends Model
{
    use HasFactory;

    function getAccomodations(){
        return $this->belongsToMany(
            accomodation::class,
            'accomodationpolicies',
            'policyid',
            'accomodationid');
    }
}
