<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cardinfo extends Model
{
    protected $primaryKey = 'cardinfoid';
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'cardholdername', 'cardnumber', 'expirationdate', 'cvv', 'email'
    ];

    public function getTransactions()
    {
        return $this->hasMany(Transaction::class, 'infoid', 'cardinfoid');
    }

}
