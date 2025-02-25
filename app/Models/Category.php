<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Category extends Model
{
    // Tell Eloquent that the primary key is a UUID and it's not auto-incrementing
    protected $keyType = 'string';
    public $incrementing = false;

    //fillable fields is product
    protected $fillable = [
        'name',
        'description'
    ];

    protected static function booted()
    {
        static::creating(function ($category) {
            if (empty($category->id)) {
                $category->id = Str::uuid();  // Generate a UUID if not already set
            }
        });
    }

    // Relationship with UserAddress model
    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
