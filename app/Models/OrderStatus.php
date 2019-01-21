<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class OrderStatus extends Model
{

    protected $table = 'order_statuses';
    protected $fillable = [
        'name',
        'notification',
        'description',
        'class'];

    public function scopeSearch($query, $search)
    {
        $search = trim(mb_strtolower($search));
        if($search)
        {
            $query->Where(   DB::raw('LOWER(name)'),  'like', "%"  . $search . "%");
            $query->OrWhere( DB::raw('LOWER(description)'),  'like', "%"  . $search . "%");
        }
        return $query;
    }

}
