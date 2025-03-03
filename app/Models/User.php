<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    protected static function booted()
    {
        static::creating(function ($user) {
            if (!$user->id) {
                $user->id = Str::uuid(); // Automatically generate UUID when creating the user
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    /**
     * Disable auto-incrementing and set key type to UUID.
     */
    public $incrementing = false; // Disable auto-incrementing
    protected $keyType = 'uuid'; // Set UUID as key type

    // Relationship with UserAddress model
    public function userAddresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    // Relationship with Orders model
    public function orders()
    {
        return $this->belongsTo(Orders::class);
    }

    // Relationship with Wishlists model
    public function wishLists()
    {
        return $this->belongsTo(Wishlists::class);
    }

    // Relationship with Comments model
    public function comments()
    {
        return $this->belongsTo(Comments::class);
    }

    // Relationship with Product model
    public function selling()
    {
        return $this->belongsTo(Product::class);
    }
}
