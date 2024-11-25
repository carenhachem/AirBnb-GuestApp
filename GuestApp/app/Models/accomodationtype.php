<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccomodationType extends Model
{
    protected $table = 'accomodationtypes';
    protected $primaryKey = 'typeid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'accomodationdesc',
        'isactive',
    ];

    // Define the relationship with the Accomodation model
    public function accomodations()
    {
        return $this->hasMany(Accomodation::class, 'typeid', 'typeid');
    }
}
