<?php
namespace App\Services;

use App\Models\AttributeValue;
use File;

class ServiceAttributeProductValue
{

    private $model;
    public function __construct()
    {
        $this->model = new AttributeValue();
    }

    public function deleteImage($attribute_id, $fileName)
    {
        $path = config('shop.attributes_path_file') . $fileName;

        if(File::exists($path))
            if(!$this->model::where('attribute_id', $attribute_id)->where('value', $fileName)->first())
                return File::delete($path) ? true : false;

        return false;
    }

}