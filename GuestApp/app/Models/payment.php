<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    use HasFactory;

    function getUsers(){
        return $this->hasMany(User::class,'paymentmethodid','paymentid');
    }
    
}
