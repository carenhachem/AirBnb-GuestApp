<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accomodation extends Model
{
    use HasFactory;

    function getPolicies()
    {
        return $this->belongsToMany(
            policy::class,
            'accomodationpolicies',
            'accomodationid',
            'policyid');
    }

    function getAmenities()
    {
        return $this->belongsToMany(
            amenity::class,
            'accomodationamenities',
            'accomodationid',
            'amenityid');
    }

    function getAccomodationType(){
        return $this->belongsTo(accomodationtype::class,'typeid','typeid');
    }

    public function getWishlists()
    {
        return $this->hasMany(wishlist::class, 'accomodationid', 'accomodationid');
    }

    public function getReviews()
    {
        return $this->hasMany(review::class, 'accomodationid', 'accomodationid');
    }

    public function getReservations()
    {
        return $this->hasMany(reservation::class, 'accomodationid', 'accomodationid');
    }

}
