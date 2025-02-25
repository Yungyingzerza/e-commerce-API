<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Wishlists extends Model
{
    // Tell Eloquent that the primary key is a UUID and it's not auto-incrementing
    protected $keyType = 'string';
    public $incrementing = false;

    //fillable fields is product
    protected $fillable = [
        'product_id',
        'user_id'
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
        return $this->hasMany(Product::class);
    }

    // Relationship with User model 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
