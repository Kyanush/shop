<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use File;

class AttributeValue extends Model
{
    protected $table = 'attribute_values';
    protected $fillable = [
    	'attribute_id',
    	'value'
	];


    protected static function boot()
    {
        parent::boot();
        //Событие после
        static::Deleting(function($model){
            $path =  config('shop.attributes_path_file') . $model->value;
            if($model->value and File::exists(public_path($path)))
                File::delete($path);

            return $model;
        });

    }



}
