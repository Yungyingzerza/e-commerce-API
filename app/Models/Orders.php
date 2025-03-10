<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Orders extends Model
{
    // Tell Eloquent that the primary key is a UUID and it's not auto-incrementing
    protected $keyType = 'string';
    public $incrementing = false;

    //fillable fields is product
    protected $fillable = [
        'product_id',
        'user_id',
        'address_id',
        'size',
        'quantity',
        'discount',
        'total_price'
    ];

    protected static function booted()
    {
        static::creating(function ($product) {
            if (empty($product->id)) {
                $product->id = Str::uuid();  // Generate a UUID if not already set
            }
        });
    }

    // Relationship with Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Relationship with UserAddress model
    public function userAddress()
    {
        return $this->belongsTo(UserAddress::class, 'address_id');
    }
}
