<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class usertoken extends Model
{
    use HasFactory;

    protected $primaryKey = 'usertokenid';  // Set primary key to 'userid'
    public $incrementing = false;     // UUIDs are not auto-incrementing
    protected $keyType = 'string';

    protected $fillable = [
        'token',
        'refreshtoken',
        'userid'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'userid', 'userid');
    }

    // public function generateApiToken()
    // {
    //     // Generate a random API token (you can also use any other secure generation logic)
    //     $token = Str::random(60);

    //     // Save it in the database
    //     $this->token = $token;
    //     $this->save();

    //     return $token;
    // }

    public function generateApiToken()
    {
        return Str::random(60); // Generate a random 60-character string as a token
    }
}
