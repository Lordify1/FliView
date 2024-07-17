<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillables = [
        "product_id",
        "quantity",
        "user_id",
        "shop_id",
    ];

    public function product()
    {
        return $this->belongsTo(User::class);
    }
}
