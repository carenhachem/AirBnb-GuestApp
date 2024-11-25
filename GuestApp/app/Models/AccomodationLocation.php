<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccomodationLocation extends Model
{
    protected $table = 'accomodationlocations'; // Correct table name
    protected $primaryKey = 'locationid'; // Primary key
    public $incrementing = false; // If the primary key is not auto-incrementing
    protected $keyType = 'string'; // UUIDs are strings
}
