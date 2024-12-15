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

    const UPDATED_AT = 'updated'; //updated instead of updated_at

    protected $fillable = [
        'description',
        'pricepernight',
        'typeid',
        'locationid',
        'guestcapacity',
        'rating',
        'image',
        'isactive',
        'updated'
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

    public function reviews()
    {
        return $this->hasMany(review::class, 'accomodationid', 'accomodationid');
    }


    public function scopeSearch($query, $keyword)
{
    if ($keyword) {
        $query->where(function($q) use ($keyword) {
            $q->where('description', 'ILIKE', "%{$keyword}%")
              ->orWhereHas('location', function ($locQ) use ($keyword) {
                  $locQ->where('city', 'ILIKE', "%{$keyword}%")
                       ->orWhere('address', 'ILIKE', "%{$keyword}%");
              })
              ->orWhereHas('type', function ($typeQ) use ($keyword) {
                  $typeQ->where('accomodationdesc', 'ILIKE', "%{$keyword}%");
              });
        });
    }
    return $query;
}

public function scopeByCity($query, $city)
{
    if ($city) {
        $query->whereHas('location', function ($q) use ($city) {
            $q->where('city', 'ILIKE', "%{$city}%");
        });
    }
    return $query;
}

public function scopeSearchByType($query, $type)
{
    if ($type) {
        $query->whereHas('type', function ($q) use ($type) {
            $q->where('accomodationdesc', 'ILIKE', "%{$type}%");
        });
    }
    return $query;
}


}