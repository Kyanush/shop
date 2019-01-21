<?php

namespace App\Models;


use App\Services\ServiceCategory;
use Illuminate\Database\Eloquent\Model;
use File;
use App\Tools\UploadableTrait;
use DB;
use App\Tools\Helpers;
use Auth;

class Product extends Model
{
    use UploadableTrait;


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
        'seo_keywords',
        'seo_description',
    	'created_at',
    	'updated_at',
        'active'
	];

    public function scopeIsActive($query){
        return $query->where('active', 1);
    }

    public function scopeNoActive($query){
        return $query->where('active', 0);
    }


    public function scopeFilters($query, $filters)
    {

        if(isset($filters['created_at_start']))
            $query->whereDate('created_at', '>=', $filters['created_at_start']);
        if(isset($filters['created_at_end']))
            $query->whereDate('created_at', '<=', $filters['created_at_end']);


        if(isset($filters['name']))
            $query->Where(   DB::raw('LOWER(name)'), 'like', "%"  . $filters['name'] . "%");


        if(isset($filters['price_start']))
            $query->where('price', '>=', $filters['price_start']);
        if(isset($filters['price_end']))
            $query->where('price', '<=', $filters['price_end']);

        if(isset($filters['sku']))
            $query->Where(   DB::raw('LOWER(sku)'), 'like', "%"  . $filters['sku'] . "%");

        if(isset($filters['stock_end']))
            $query->where('stock', '>=', $filters['stock_end']);
        if(isset($filters['stock_start']))
            $query->where('stock', '<=', $filters['stock_start']);

        if(isset($filters['url']))
            $query->Where(   DB::raw('LOWER(url)'), 'like', "%"  . $filters['url'] . "%");

        if(isset($filters['active']))
            $query->where('active', $filters['active']);

        if(isset($filters['category']))
        {
            $serviceCategory = new ServiceCategory();

            $parent_id = Category::where('url', $filters['category'])->first()->id;
            $categories_ids = $serviceCategory->categoryChildIds($parent_id);

            $query->whereHas('categories', function($query) use ($categories_ids){
                $query->whereIn('category_id', $categories_ids);
            });

        }

        return $query;
    }

    public function scopeFiltersAttributes($query, $filters){
        if(!empty($filters))
        {
            $attribute_codes = $value_codes = $values = [];

            foreach ($filters as $code => $value)
            {
                if(!empty($code) and !empty($value))
                {
                    $attribute_codes[] = $code;
                    if(is_array($value)){
                        foreach ($value as $v)
                            if(trim($v))
                                $value_codes[] = $v;
                }elseif(trim($value))
                        $value_codes[] = $value;
                }
            }

            if(count($attribute_codes) > 0 and count($value_codes) > 0)
            {
                $attributes = Attribute::whereIn('code', $attribute_codes)->with(['values' => function($query) use ($value_codes){
                    $query->whereIn('code', $value_codes);
                }])->get();

                foreach ($attributes as $attribute)
                {
                    foreach ($attribute->values as $value)
                    {
                        $values[] = $value->value;
                    }
                }

                if($attribute_codes and $values)
                    $query->whereHas('attributes', function ($query) use ($attribute_codes, $values){
                        $query->whereIn('code',  $attribute_codes);
                        $query->whereIn('value', $values);
                    });
            }
        }
        return $query;
    }




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

            //группа товара
            if(empty($product->group_id))
                $product->group_id = ProductGroup::create()->id;

            //чпу
            $product->url = str_slug(empty($product->url) ? $product->name : $product->url);

            //фото
            if(is_uploaded_file($product->photo))
            {
                if(!empty($product->id)){
                    self::find($product->id)->deletePhoto();
                }else{
                    $statement = DB::select("show table status like '" . env('DB_TABLE_PREFIX') . "products'");
                    $product_id = $statement[0]->Auto_increment;
                }

                $product->photo = $product->uploadFile($product->photo, $product->productFileFolder(false, $product_id ?? 0));
            }

        });
    }



	public function categories()
	{
        return $this->belongsToMany('App\Models\Category', 'category_product', 'product_id', 'category_id');
    }

	public function attributes()
	{
		return $this->belongsToMany('App\Models\Attribute', 'attribute_product_value', 'product_id', 'attribute_id')
                    ->withPivot('value');
	}

	public function images()
	{
		return $this->hasMany('App\Models\ProductImage')->orderBy('order', 'ASC');
	}

    public function productAccessories()
    {
        return $this->belongsToMany('App\Models\Product', 'product_accessories', 'product_id', 'accessory_product_id');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review', 'product_id', 'id');
    }

    public function questionsAnswers()
    {
        return $this->hasMany('App\Models\QuestionAnswer', 'product_id', 'id');
    }

    public function avgRating()
    {
        return $this->hasOne('App\Models\Review', 'product_id', 'id')
                    ->select(['product_id', DB::raw('TRUNCATE(avg(rating), 0) as avg_rating')])
                    ->isActive()
                    ->GroupBy('product_id');
    }

    public function group()
    {
        return $this->belongsTo('App\Models\ProductGroup');
    }

    public function groupProducts()
    {
        return $this->hasMany('App\Models\Product', 'group_id', 'group_id');
    }

    public function specificPrice()
    {
        return $this->belongsTo('App\Models\SpecificPrice', 'id', 'product_id');
    }

    public function oneProductFeaturesCompare()
    {
        return $this->hasOne('App\Models\ProductFeaturesCompare', 'product_id', 'id')
                    ->where('visit_number', Helpers::getVisitNumber());
    }

    public function oneProductFeaturesWishlist()
    {
        return $this->hasOne('App\Models\ProductFeaturesWishlist', 'product_id', 'id')
                    ->where('user_id', Auth::check() ? Auth::user()->id : 0);
    }

    public function inCart(){
        return $this->hasOne('App\Models\CartItem', 'product_id', 'id')
                    ->whereHas('cart', function ($query){
                         $query->currentUser();
                    });
    }

    public function scopeProductInfoWith($query){
        return
        $query->with([
            'specificPrice' => function($query){
                $query->dateActive();
            },
            'attributes',
            'categories',
            'avgRating',
            'oneProductFeaturesCompare',
            'oneProductFeaturesWishlist',
            'inCart'
        ])
        ->isActive()
        ->withCount(['reviews' => function($query){
            $query->isActive();
        }]);
    }



    /**** Скидки   ***/
    public function getReducedPrice()
    {
        $price = $this->price;

        if(isset($this->specificPrice))
        if($this->specificPrice)
        {
            $current_date = date('Y-m-d H:i:s');
            if(
                ($this->specificPrice->start_date <= $current_date and $this->specificPrice->expiration_date >= $current_date)
                or
                (empty($this->specificPrice->start_date) and empty($this->specificPrice->expiration_date))
                or
                ($this->specificPrice->start_date <= $current_date and empty($this->specificPrice->expiration_date))
                or
                (empty($this->specificPrice->start_date) and $this->specificPrice->expiration_date >= $current_date)
            )
            {
                if($price)
                {
                    if($this->specificPrice->discount_type == 'percent'){
                        $price = $price - $this->specificPrice->reduction / 100 * $price;
                    }
                    if($this->specificPrice->discount_type == 'sum'){
                        $price = $price - $this->specificPrice->reduction;
                    }
                }
            }
        }

        return $price;
    }
    public function getDiscountTypeinfo(){

        if(isset($this->specificPrice))
            if($this->specificPrice)
                switch ($this->specificPrice->discount_type) {
                    case 'percent':
                        return '-' . $this->specificPrice->reduction . '%';
                        break;
                    case 'sum':
                        return   '-' . $this->specificPrice->reduction . '₸';
                        break;
                    default:
                        return '';
                }
        return '';
    }





    public function detailUrlProduct(){
        return '/product/' . $this->categories[0]->url . '/' . $this->url;
    }

    public function detailUrlProductAdmin(){
        return '/admin/products/edit/' . $this->id;
    }

    public function pathPhoto($firstSlash = false)
    {
        if(!empty($this->photo))
            return $this->productFileFolder($firstSlash) . $this->photo;
        else
            false;
    }

    public function productFileFolder($firstSlash = false, $product_id = 0)
    {
        return ($firstSlash ? '/' : '') . config('shop.products_path_file') . (empty($product_id) ? $this->id : $product_id) . '/';
    }

    public function deletePhoto()
    {
        if($this->pathPhoto())
           return File::delete($this->pathPhoto());
        else
            return false;
    }

}