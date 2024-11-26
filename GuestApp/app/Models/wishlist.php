<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wishlist extends Model
{
    use HasFactory;

    protected $primaryKey = 'wishlistid';  // Set primary key to 'userid'
    public $incrementing = false;     // UUIDs are not auto-incrementing
    protected $keyType = 'uuid';

    public function user()
    {
        return $this->belongsTo(User::class, 'userid', 'userid');
    }

    //each wishlist entry corresponds to exactly one accommodation
    public function accomodation()
    {
        return $this->belongsTo(accomodation::class, 'accomodationid', 'accomodationid');
    }
}
