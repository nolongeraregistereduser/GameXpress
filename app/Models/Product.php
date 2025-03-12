<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['name', 'slug','price', 'stock', 'status','category_id'];
}


// 'price, stock', 'status'   add this later for products 
