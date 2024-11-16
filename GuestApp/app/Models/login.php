<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class login extends Model
{
    use HasFactory;

    function getUsers(){
        return $this->hasMany(User::class,'loginmethodid','loginmethodid');
    }
}
