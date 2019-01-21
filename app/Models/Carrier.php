<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use File;
use DB;
use App\Tools\UploadableTrait;

class Carrier extends Model
{
    use UploadableTrait;

    protected $table = 'carriers';
    public $timestamps = false;
    protected $fillable = [
    	'name',
    	'price',
    	'delivery_text',
    	'logo'
	];

    public function scopeSearch($query, $search){
        $search = trim(mb_strtolower($search));
        if($search)
        {
            $query->Where(   DB::raw('LOWER(name)'),          'like', "%"  . $search . "%");
            $query->OrWhere( DB::raw('LOWER(price)'),         'like', "%"  . $search . "%");
            $query->OrWhere( DB::raw('LOWER(delivery_text)'), 'like', "%"  . $search . "%");
        }
        return $query;
    }

 	public static function boot()
    {

        parent::boot();
        static::deleting(function($obj) {
            $obj->deleteLogo();
        });

        //Событие до
        static::Saving(function($model){
            if(is_uploaded_file($model->logo))
            {
                if($model->id)
                    self::find($model->id)->deleteLogo();

                $model->logo = $model->uploadFile($model->logo, config('shop.carriers_path_file'));
            }
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
