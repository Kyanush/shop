<?php

namespace App\Http\Controllers\Admin\Api;
use App\Http\Controllers\Admin\AdminController;
use App\Requests\SaveAttributeRequest;
use App\Services\ServiceAttribute;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Tools\UploadableTrait;
use DB;
use File;

class AttributeController extends AdminController
{
    use UploadableTrait;

    private $serviceAttribute;
    public function __construct(ServiceAttribute $serviceAttribute)
    {
        $this->serviceAttribute = $serviceAttribute;
    }

    public function list(Request $request)
    {
        $search = trim(mb_strtolower($request->input('search')));

        $list =  Attribute::where(function ($query) use ($search){

                if(!empty($search))
                {
                    $query->Where(   DB::raw('LOWER(name)'), 'like', "%"  . $search . "%");
                    $query->OrWhere( DB::raw('LOWER(type)'), 'like', "%"  . $search . "%");
                }

            })
            ->OrderBy('id', 'DESC')
            ->paginate($request->input('per_page') ?? 100);

        return  $this->sendResponse($list);
    }

    //SaveAttribute
    public function save(SaveAttributeRequest $request)
    {
        $data = $request->all();
        $data = $data['attribute'];

         $attribute = Attribute::findOrNew($data["id"]);
         $attribute->name     = $data['name'];
         $attribute->type     = $data['type'];
         $attribute->required = $data['required'];

         if($attribute->save())
         {
             foreach ($data['values'] as $item)
             {
                if(intval($item['is_delete'])){
                    AttributeValue::destroy($item['id']);
                }else{
                    $attrValue = AttributeValue::findOrNew($item['id']);

                    if($attribute->type == 'media')
                    {
                         if(!empty($attrValue->value) and is_file($item['value']))
                             File::delete(public_path(config('shop.attributes_path_file') . $attrValue->value));

                         $item['value'] = $this->uploadFile($item['value'], config('shop.attributes_path_file'));
                    }

                    $attrValue->value        = $item['value'];
                    $attrValue->attribute_id = $attribute->id;
                    $attrValue->save();
                }
             }
         }

         return  $this->sendResponse($attribute->id);
    }



    public function view($id)
    {
        return  $this->sendResponse(
            Attribute::select(['id', 'name', 'type', 'required'])->with(['values' => function($query){
                $query->select(['id', 'attribute_id', 'value']);
            }])->findOrFail($id)
        );
    }


    public function delete($id)
    {
        return  $this->sendResponse(Attribute::destroy($id) ? true : false);
    }





}
