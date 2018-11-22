<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AttributeValue;

class Attribute extends Model
{
    protected $table = 'attributes';
    protected $fillable = [
    	'type',
	 	'name'
 	];

    public static function  scopeIsRequired($query)
    {
        return $query->where('required', 1);
    }

    public static function  scopeNoRequired($query)
    {
        return $query->where('required', 0);
    }

    protected static function boot()
    {
        parent::boot();

        //Событие до
    	static::deleting(function($model) {
	        if (count($model->sets) == 0) {

    	        foreach ($model->values as $item)
                    AttributeValue::destroy($item->id);

            } else {
    			return $model;
    		}
        });
    }

	public function values()
    {
        return $this->hasMany('App\Models\AttributeValue', 'attribute_id', 'id');
    }

    public function sets()
    {
    	return $this->belongsToMany('App\Models\AttributeSet', 'attribute_attribute_set', 'attribute_id', 'attribute_set_id');
    }

}
