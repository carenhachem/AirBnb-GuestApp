<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $primaryKey = 'transactionid';
    public $incrementing = false;

    protected $keyType = 'uuid';


    protected $fillable = [
        'transactionid', 'userid', 'infoid', 'amount', 'paydate', 'address', 'city', 'state', 'zipcode'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid', 'userid');
    }

    public function cardInfo()
    {
        return $this->belongsTo(Cardinfo::class, 'infoid', 'cardinfoid');
    }

}
