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

    public function user()
    {
        return $this->belongsTo(User::class, 'userid', 'userid');
    }

    public function accomodation()
    {
        return $this->belongsTo(accomodation::class, 'accomodationid', 'accomodationid');
    }
}
