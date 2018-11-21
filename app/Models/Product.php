<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use File;

class Product extends Model
{

    protected $table = 'products';
    protected $fillable = [
    	'group_id',
    	'attribute_set_id',
    	'name',
    	'description',
        'photo',
    	'price',
    	'tax_id',
    	'sku',
    	'stock',
    	'active',
    	'created_at',
    	'updated_at'
	];



	protected static function boot()
    {
        parent::boot();

        static::deleting(function($model) {
            /*
            $model->categories()->detach();
            $model->attributes()->detach();
            $model->deletePhoto();

            // Delete product images
            $disk = 'products';

            foreach ($model->images as $image) {
                // Delete image from disk
                if (\Storage::disk($disk)->has($image->name)) {
                    \Storage::disk($disk)->delete($image->name);
                }

                // Delete image from db
                $image->delete();
            }*/
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

    public function attributeProductValue()
    {
        return $this->hasMany('App\Models\AttributeProductValue', 'product_id', 'id');
    }

	public function tax()
	{
		return $this->hasOne('App\Models\Tax');
	}

	public function images()
	{
		return $this->hasMany('App\Models\ProductImage')->orderBy('order', 'ASC');
	}

    public function group()
    {
        return $this->belongsTo('App\Models\ProductGroup');
    }

    public function cartRules()
    {
        return $this->belongsToMany('App\Models\CartRule');
    }

    public function specificPrice()
    {
        return $this->belongsTo('App\Models\SpecificPrice', 'id', 'product_id');
    }









    public function scopeLoadCloneRelations($query)
    {
        $query->with('categories', 'attributes', 'images');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }


    public function pathPhoto()
    {
        if(!empty($this->photo))
            return '/' . config('shop.products_path_file') . $this->id . '/' . $this->photo;
        else
            false;
    }

    public function deletePhoto(){
	   $path = $this->pathPhoto();
	   if($path)
           return File::delete(substr($path, 1));
    }

}
