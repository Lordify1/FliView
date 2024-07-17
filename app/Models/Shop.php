<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_name',
        'shop_description',
        'shop_address',
        'shop_phone',
        'opening_time',
        'closing_time',
        'shop_logo',
        'shop_email',
        'payment_method',
        'payment_currency',
    ];

    public function user()
    {
        return $this->belongTo(User::class);
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }

}
