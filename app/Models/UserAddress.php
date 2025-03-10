<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserAddress extends Model
{
    // Tell Eloquent that the primary key is a UUID and it's not auto-incrementing
    protected $keyType = 'string';
    public $incrementing = false;

    //fillable fields is address
    protected $fillable = [
        'address',
    ];


    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function ($userAddress) {
            if (empty($userAddress->id)) {
                $userAddress->id = Str::uuid();  // Generate a UUID if not already set
            }
        });
    }

    // Define the relationship with the Orders model
    public function orders()
    {
        return $this->hasMany(Orders::class);
    }

    
}
