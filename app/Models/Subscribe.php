<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Subscribe extends Model
{

    protected $table = 'subscribe';
    protected $fillable = [
        'email',
        'product_id'
	];

    public function scopeSearch($query, $search){
        $search = trim(mb_strtolower($search));
        if($search)
        {
            $query->Where(   DB::raw('LOWER(email)'), 'like', "%"  . $search . "%");
        }
        return $query;
    }

}