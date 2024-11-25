<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'userid';  // Set primary key to 'userid'
    public $incrementing = false;     // UUIDs are not auto-incrementing
    protected $keyType = 'uuid';

    function getLoginMethod(){
        return $this->belongsTo(login::class,'loginmethodid','loginmethodid');
    }
    
    public function getWishlists()
    {
        return $this->hasMany(wishlist::class, 'userid', 'userid');
    }

    public function getReviews()
    {
        return $this->hasMany(review::class, 'userid', 'userid');
    }

    public function getReservations()
    {
        return $this->hasMany(reservation::class, 'userid', 'userid');
    }

    public function token()
    {
        return $this->hasOne(usertoken::class, 'userid', 'userid');
    }

    public function getTransactions()
    {
        return $this->hasMany(Transaction::class, 'userid', 'userid');
    }


    public function refreshtoken()
    {
        return $this->hasOne(RefreshToken::class, 'userid', 'userid');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "userid",
        'first_name',
        'last_name',
        'email',
        'username',
        'password',
        'google_id',
        'profilepic',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
}
