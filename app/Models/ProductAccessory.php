<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAccessory extends Model
{

    protected $table = 'product_accessories';
    protected $fillable = [
        'accessory_product_id',
        'product_id'
    ];

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'accessory_product_id');
    }

}