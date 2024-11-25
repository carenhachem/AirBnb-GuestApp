<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $table = 'amenities';
    protected $primaryKey = 'amenityid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'amenitydesc',
        'isactive',
    ];

    public function accomodations()
    {
        return $this->belongsToMany(Accomodation::class, 'accomodationamenities', 'amenityid', 'accomodationid');
    }
}
