<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{

    protected $table = 'cart_items';
    protected $fillable = [
        'product_id',
        'quantity'
    ];

    public function cart(){
        return $this->hasOne('App\Models\Cart', 'id', 'cart_id');
    }

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

}