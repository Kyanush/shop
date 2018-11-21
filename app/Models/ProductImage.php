<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use File;

class ProductImage extends Model
{

    /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    protected $table = 'product_images';
    //protected $primaryKey = 'id';
    public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
    	'product_id',
    	'name',
    	'order'
	];
    // protected $hidden = [];
    // protected $dates = [];

    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| SCOPES
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| ACCESORS
	|--------------------------------------------------------------------------
	*/

    /**
     * Get the image path on disk.
     *
     * @return string
     */

    public function imagePath()
    {
        return '/' . config('shop.products_path_file') . $this->product_id . '/' . $this->name;
    }

    protected static function boot()
    {
        parent::boot();

        //Событие до
        static::Deleting(function($modal) {
            if($modal->name)
                File::delete(substr($modal->imagePath(), 1));
        });
    }

}
