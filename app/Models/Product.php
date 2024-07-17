<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model 
{
    use HasFactory;

    protected $table = "products";

    protected $fillables = [
        "name",
        "description",
        "product_category_id",
        "product_sizes",
        "price",
        "color",
        "how_many",
        "product_status",
        "shop_id",
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function product_images()
    {
        return $this->hasMany(Product_images::class);
    }

   
}
