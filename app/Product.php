<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'id',
        'product_name',
        'price'
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product');
    }
}
