<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Category extends Model
{
    // Tell Eloquent that the primary key is a UUID and it's not auto-incrementing
    protected $keyType = 'string';
    public $incrementing = true;
    protected $table = 'category'; // Set the correct table name


    //fillable fields is product
    protected $fillable = [
        'name',
        'description'
    ];

    protected static function booted()
    {
    }

    // Relationship with UserAddress model
    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
