<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use File;

class Carrier extends Model
{

    protected $table = 'carriers';
    public $timestamps = false;
    protected $fillable = [
    	'name',
    	'price',
    	'delivery_text',
    	'logo'
	];

 	public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {

            $obj->deleteLogo();
            
        });
    }

    public function pathLogo($firstSlash = false)
    {
        if(!empty($this->logo))
            return ($firstSlash ? '/' : '') . config('shop.carriers_path_file') . $this->logo;
        else
            false;
    }

    public function deleteLogo(){
        return File::delete($this->pathLogo());
    }


}
