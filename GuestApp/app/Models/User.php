<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    function getLoginMethod(){
        return $this->belongsTo(login::class,'loginmethodid','loginmethodid');
    }

    function getPaymentMethod(){
        return $this->belongsTo(payment::class,'paymentmethodid','paymentid');
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

    public function getTransactions()
    {
        return $this->hasMany(Transaction::class, 'userid', 'userid');
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
