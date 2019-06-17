<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Banner extends Model
{

    protected $table = 'banners';
    public $timestamps = false;
    protected $fillable = [
    	'name',
    	'link',
    	'body'
	];

    public function scopeSearch($query, $search){
        $search = trim(mb_strtolower($search));
        if($search)
        {
            $query->Where(   DB::raw('LOWER(name)'),         'like', "%"  . $search . "%");
            $query->OrWhere( DB::raw('LOWER(link)'),         'like', "%"  . $search . "%");
        }
        return $query;
    }

}
