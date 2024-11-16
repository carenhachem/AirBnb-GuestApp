<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wishlist extends Model
{
    use HasFactory;

    public function getUser()
    {
        return $this->belongsTo(User::class, 'userid', 'userid');
    }

    //each wishlist entry corresponds to exactly one accommodation
    public function getAccomodation()
    {
        return $this->belongsTo(accomodation::class, 'accomodationid', 'accomodationid');
    }
}
