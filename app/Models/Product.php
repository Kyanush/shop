<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use File;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'products';
    protected $fillable = [
    	'group_id',
    	'attribute_set_id',
    	'name',
        'url',
    	'description',
        'photo',
    	'price',
    	'sku',
    	'stock',
    	'created_at',
    	'updated_at',
        'deleted_at'
	];



	protected static function boot()
    {
        parent::boot();



        //до
        static::deleting(function($product) {
        });

        //после
        static::Deleted(function($product) {
        });

        //Событие до
        static::Saving(function($product) {

            //чпу
            $product->url = str_slug(empty($product->url) ? $product->name : $product->url);

        });




    }



	public function categories()
	{
        return $this->belongsToMany('App\Models\Category', 'category_product', 'product_id', 'category_id');
    }

	public function attributes()
	{
		return $this->belongsToMany('App\Models\Attribute', 'attribute_product_value', 'product_id', 'attribute_id')->withPivot('value');
	}

	/*
    public function attributeProductValue()
    {
        return $this->hasMany('App\Models\AttributeProductValue', 'product_id', 'id');
    }*/



	public function images()
	{
		return $this->hasMany('App\Models\ProductImage')->orderBy('order', 'ASC');
	}

    public function group()
    {
        return $this->belongsTo('App\Models\ProductGroup');
    }

    public function specificPrice()
    {
        return $this->belongsTo('App\Models\SpecificPrice', 'id', 'product_id');
    }







    public function scopeLoadCloneRelations($query)
    {
        $query->with('categories', 'attributes', 'images');
    }




    public function pathPhoto($firstSlash = false)
    {
        if(!empty($this->photo))
            return $this->productFileFolder($firstSlash) . $this->photo;
        else
            false;
    }

    public function productFileFolder($firstSlash = false)
    {
        return ($firstSlash ? '/' : '') . config('shop.products_path_file') . $this->id . '/';
    }


    public function deletePhoto()
    {
       return File::delete($this->pathPhoto());
    }



}