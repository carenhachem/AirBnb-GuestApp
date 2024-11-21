<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    
    function getUsers(){
        return $this->hasMany(User::class,'paymentmethodid','paymentid');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'paymentmethodid', 'paymentid');
    }

    
}
