<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reservation extends Model
{
    use HasFactory;

    protected $primaryKey = 'reservationid';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'reservationid',
        'userid',
        'accomodationid',
        'checkin',
        'checkout',
        'totalprice',
        'isreserved',
    ];

    protected $dates = ['checkin', 'checkout'];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid', 'userid');
    }

    public function accomodation()
    {
        return $this->belongsTo(Accomodation::class, 'accomodationid', 'accomodationid');
    }
}
