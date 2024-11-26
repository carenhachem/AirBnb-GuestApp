<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accomodation extends Model
{
    protected $table = 'accomodations';
    protected $primaryKey = 'accomodationid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'description',
        'pricepernight',
        'typeid',
        'locationid',
        'guestcapacity',
        'rating',
        'image',
        'isactive',
    ];

    // Relationships
    public function type()
{
    return $this->belongsTo(AccomodationType::class, 'typeid', 'typeid');
}


public function location()
{
    return $this->belongsTo(AccomodationLocation::class, 'locationid', 'locationid');
}


    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'accomodationamenities', 'accomodationid', 'amenityid');
    }

    // Query Scopes
    public function scopePriceRange($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('pricepernight', [$minPrice, $maxPrice]);
    }

    public function scopeByType($query, $type)
    {
        return $query->whereHas('type', function ($q) use ($type) {
            $q->where('accomodationdesc', $type);
        });
    }

    public function scopeByLocation($query, $location)
    {
        return $query->whereHas('location', function ($q) use ($location) {
            $q->where('city', $location);
        });
    }

    public function wishlists()
    {
        return $this->hasMany(wishlist::class, 'accomodationid', 'accomodationid');
    }

    public function reservations()
    {
        return $this->hasMany(reservation::class, 'accomodationid', 'accomodationid');
    }

}