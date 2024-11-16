<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class review extends Model
{
    use HasFactory;

    function getAccomodation(){
        return $this->belongsTo(accomodation::class,'accomodationid','accomodationid');
    }

    public function getUser()
    {
        return $this->belongsTo(User::class, 'userid', 'userid');
    }
}
