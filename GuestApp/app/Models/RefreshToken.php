<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefreshToken extends Model
{
    use HasFactory;

    protected $primaryKey = 'refreshtokenid';  // Set primary key to 'userid'
    public $incrementing = false;     // UUIDs are not auto-incrementing
    protected $keyType = 'uuid';

    protected $fillable = [
        'refresh_token', 'userid', 'expires_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
