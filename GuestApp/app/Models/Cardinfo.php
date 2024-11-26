<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cardinfo extends Model
{
    protected $primaryKey = 'cardinfoid';
    protected $keyType = 'uuid';
    public $incrementing = false;
    
    protected $fillable = ['cardinfoid', 'nameoncard', 'creditcardnumber', 'expmonth', 'expyear', 'cvv'];


    public function getTransactions()
    {
        return $this->hasMany(Transaction::class, 'infoid', 'cardinfoid');
    }

}
