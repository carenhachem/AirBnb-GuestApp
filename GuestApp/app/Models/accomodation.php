<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accomodation extends Model
{
    //check function amenities() and wishlists() : same return type... 
    use HasFactory;

    protected $table = 'accomodations';
    protected $primaryKey = 'accomodationid'; 
    public $incrementing = false;     
    protected $keyType = 'uuid';  // or string from joe

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

    function policies()
    {
        return $this->belongsToMany(
            policy::class,
            'accomodationpolicies',
            'accomodationid',
            'policyid');
    }

    public function location()
    {
        return $this->belongsTo(AccomodationLocation::class, 'locationid', 'locationid');
    }

    public function type()
    {
        return $this->belongsTo(AccomodationType::class, 'typeid', 'typeid');
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'accomodationamenities', 'accomodationid', 'amenityid');
    }

    public function wishlists()
    {
        return $this->belongsToMany(Amenity::class, 'accomodationamenities', 'accomodationid', 'amenityid');
    }

    public function reviews()
    {
        return $query->whereBetween('pricepernight', [$minPrice, $maxPrice]);
    }

    public function reservations()
    {
        return $query->whereHas('type', function ($q) use ($type) {
            $q->where('accomodationdesc', $type);
        });
    }

    //scopes

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
}
