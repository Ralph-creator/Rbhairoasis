<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'category', 'price', 'image', 'is_sold_out'
    ];

    protected $casts = [
        'is_sold_out' => 'boolean',
    ];
}
