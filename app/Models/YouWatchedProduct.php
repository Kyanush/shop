<?php

namespace App\Models;

use App\Tools\Helpers;
use Illuminate\Database\Eloquent\Model;

class YouWatchedProduct extends Model
{

    protected $table = 'you_watched_products';
    protected $fillable = [
        'visit_number',
        'product_id'
    ];

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    public function scopeSearchVisitNumber($query, $visit_number = '')
    {
        if(empty($visit_number))
            $visit_number = Helpers::getVisitNumber();

        $query->where('visit_number', $visit_number);
        return $query;
    }

}