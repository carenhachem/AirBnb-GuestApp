<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reservation extends Model
{
    use HasFactory;

    public function getUser()
    {
        return $this->belongsTo(User::class, 'userid', 'userid');
    }

    public function getAccomodation()
    {
        return $this->belongsTo(accomodation::class, 'accomodationid', 'accomodationid');
    }
}
