<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'image',
        'description',
        'price',
        'stock_quantity',
        'view_count',
        'search_count',
        'purchase_count',
        'is_active',
    ];
}
