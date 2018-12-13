<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class SpecificPrice extends Model
{

    protected $table = 'specific_prices';

    protected $fillable = [
                           'reduction',
                           'discount_type',
                           'start_date',
                           'expiration_date',
                           'product_id',
    ];

    public function getReducedPrice()
    {
        $oldPrice = $this->product->price;

        if($oldPrice) {

            if($this->discount_type == 'percent'){
                return number_format($oldPrice - $this->reduction / 100 * $oldPrice, 2);
            }
            if($this->discount_type == 'sum'){
                return number_format($oldPrice - $this->reduction, 2);
            }
            return number_format($oldPrice, 2);
        }
        return $oldPrice;
    }

    public function scopeDateActive($query)
    {
        $current_date = date('Y-m-d H:i:s');

        return $query->where(function ($query) use ($current_date){
                    $query->whereDate('start_date',      '<=', $current_date)
                          ->whereDate('expiration_date', '>=', $current_date);

               })->where(function ($query) use ($current_date) {
                    $query->whereDate('start_date',      '<=', $current_date)
                        ->orWhereDate('expiration_date', '>=', $current_date);

               })->where(function ($query) use ($current_date) {
                    $query->whereNull('start_date')
                          ->whereNull('expiration_date');
               })
               ->where('reduction', '>', 0);
    }

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
}
