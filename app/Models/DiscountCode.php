<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DiscountCode extends Model
{
        // Tell Eloquent that the primary key is a UUID and it's not auto-incrementing
        protected $keyType = 'string';
        public $incrementing = false;
    

        protected static function booted()
        {
            static::creating(function ($discount_code) {
                if (empty($discount_code->id)) {
                    $discount_code->id = Str::uuid();  // Generate a UUID if not already set
                }
            });
        }
}
