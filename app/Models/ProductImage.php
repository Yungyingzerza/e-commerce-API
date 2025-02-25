<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductImage extends Model
{
    // Tell Eloquent that the primary key is a UUID and it's not auto-incrementing
    protected $keyType = 'string';
    public $incrementing = false;

    //fillable fields is product
    protected $fillable = [
        'image_url',
    ];

    protected static function booted()
    {
        static::creating(function ($product_images) {
            if (empty($product_images->id)) {
                $product_images->id = Str::uuid();  // Generate a UUID if not already set
            }
        });
    }

    // Relationship with UserAddress model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
