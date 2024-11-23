<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accomodation extends Model
{
    use HasFactory;

    protected $primaryKey = 'accomodationid'; 
    public $incrementing = false;     
    protected $keyType = 'uuid';

    function policies()
    {
        return $this->belongsToMany(
            policy::class,
            'accomodationpolicies',
            'accomodationid',
            'policyid');
    }

    function amenities()
    {
        return $this->belongsToMany(
            amenity::class,
            'accomodationamenities',
            'accomodationid',
            'amenityid');
    }

    function accomodationType(){
        return $this->belongsTo(accomodationtype::class,'typeid','typeid');
    }

    public function wishlists()
    {
        return $this->hasMany(wishlist::class, 'accomodationid', 'accomodationid');
    }

    public function reviews()
    {
        return $this->hasMany(review::class, 'accomodationid', 'accomodationid');
    }

    public function reservations()
    {
        return $this->hasMany(reservation::class, 'accomodationid', 'accomodationid');
    }

    public function location()
    {
        return $this->belongsTo(accomodationlocation::class, 'locationid', 'locationid');
    }

}
