<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accomodationlocation extends Model
{    
    use HasFactory;

    public function getAccomodations()
    {
        return $this->hasMany(accomodation::class, 'locationid', 'locationid');
    }
}
