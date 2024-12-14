<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class review extends Model
{
    use HasFactory;

    protected $primaryKey = 'reviewid';  
    public $incrementing = false;     
    protected $keyType = 'uuid';

    protected $fillable = [
        "userid",
        'accomodationid',
        'rating',
        'review'
    ];

    function accomodation(){
        return $this->belongsTo(accomodation::class,'accomodationid','accomodationid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userid', 'userid');
    }
}
