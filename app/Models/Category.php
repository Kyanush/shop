<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
     protected $table = 'categories';
     protected $fillable = [
         'parent_id',
         'name',
         'slug',
         'lft',
         'rgt',
         'depth'
	];


    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }



}
