<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accomodationtype extends Model
{
    use HasFactory;

    function getAccomodations(){
        return $this->hasMany(accomodation::class,'typeid','typeid');
    }

}
