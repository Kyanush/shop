<?php
namespace App\Services;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Tools\UploadableTrait;
use File;

class ServiceAttribute
{
    use UploadableTrait;

    private $model;
    public function __construct()
    {
        $this->model = new Attribute();
    }

    public function attributeSave($data)
    {
        $attribute = $this->model::findOrNew($data["id"]);
        $attribute->fill($data);
        if($attribute->save())
        {
            if(isset($data['values']))
                foreach ($data['values'] as $key => $item)
                {
                    if(intval($item['is_delete'])){
                        //AttributeValue::destroy($item['id']);
                        $attribute->values()->destroy($item['id']);
                    }else{
                        $value = $attribute->values()->findOrNew($item['id']);

                        if($attribute->type == 'media')
                        {
                            if(!empty($value->value) and (is_uploaded_file($item['value']) or empty($item['value'])))
                            {
                                $path_delete = config('shop.attributes_path_file') . $value->value;
                                if(File::exists($path_delete))
                                    File::delete($path_delete);
                            }
                            if(is_uploaded_file($item['value']))
                                $item['value'] = $this->uploadFile($item['value'], config('shop.attributes_path_file'));
                        }

                        $value->fill($item);
                        $value->save();
                    }
                }
        }

        return $attribute ?? false;
    }

}