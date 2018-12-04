<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use File;

class Payment extends Model
{

    protected $table = 'payments';
    public $timestamps = false;
    protected $fillable = [
    	'name',
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
            return ($firstSlash ? '/' : '') . config('shop.payments_path_file') . $this->logo;
        else
            false;
    }

    public function deleteLogo(){
        return File::delete($this->pathLogo());
    }


}
