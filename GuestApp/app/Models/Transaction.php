<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $primaryKey = 'transactionid';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'userid',
        'paymentmethodid',
        'infoid',
        'amount',
        'paydate',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid', 'userid');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(Payment::class, 'paymentmethodid', 'paymentid');
    }

    public function cardInfo()
    {
        return $this->belongsTo(Cardinfo::class, 'infoid', 'cardinfoid');
    }

}
