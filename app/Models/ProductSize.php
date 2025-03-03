<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductSize extends Model
{
    // Tell Eloquent that the primary key is a UUID and it's not auto-incrementing
    protected $keyType = 'string';
    public $incrementing = false;

    //fillable fields is address
    protected $fillable = [
        'product_id',
        'size',
        'stock',
    ];

    protected static function booted()
    {
        static::creating(function ($productSize) {
            if (empty($productSize->id)) {
                $productSize->id = Str::uuid();  // Generate a UUID if not already set
            }
        });
    }

    // Define a relationship with the Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
