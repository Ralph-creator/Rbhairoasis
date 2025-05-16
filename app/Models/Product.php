<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'category',
        'price',
        'image_path', // ✅ corrected field
        'is_sold_out',
        'is_featured', // ✅ also used in the controller
    ];

    protected $casts = [
        'is_sold_out' => 'boolean',
        'is_featured' => 'boolean',
    ];
}
