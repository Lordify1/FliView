<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_images extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongTo(User::class);
    }
    
    public function product()
    {
        return $this->belongTo(Product::class);
    }
}
