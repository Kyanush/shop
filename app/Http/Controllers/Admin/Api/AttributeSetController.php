<?php

namespace App\Http\Controllers\Admin\Api;
use App\Http\Controllers\Admin\AdminController;

use App\Models\AttributeAttributeSet;
use App\Models\AttributeSet;
use App\Requests\SaveAttributeSetRequest;
use Illuminate\Http\Request;
use DB;

class AttributeSetController extends AdminController
{

    public function list(Request $request)
    {
        $search = trim(mb_strtolower($request->input('search')));

        $list =  AttributeSet::where(function ($query) use ($search){

                    if(!empty($search))
                        $query->Where(   DB::raw('LOWER(name)'), 'like', "%"  . $search . "%");

                })
                ->OrderBy('id', 'DESC')
                ->paginate($request->input('per_page') ?? 100);

        return  $this->sendResponse($list);
    }

    public function view($id)
    {
        $AttributeSet = AttributeSet::select(['id', 'name'])->with(['attributes' => function($query){
            $query->select(DB::raw('t_attributes.id'));
        }])->findOrFail($id);

        foreach ($AttributeSet->attributes as $k => $v)
            $AttributeSet->attributes[$k] = $v->id;

        return  $this->sendResponse(
            $AttributeSet
        );
    }

    public function save(SaveAttributeSetRequest $request)
    {
        $data = $request->all();
        $data = $data['attribute_set'];

        $attribute = AttributeSet::findOrNew($data["id"]);
        $attribute->name = $data['name'];
        if($attribute->save())
        {

            AttributeAttributeSet::where('attribute_set_id', $attribute->id)->delete();

            foreach ($data['attributes'] as $attribute_id)
            {
                AttributeAttributeSet::create([
                    'attribute_id' => $attribute_id,
                    'attribute_set_id' => $attribute->id
                ]);
            }
        }

        return  $this->sendResponse($attribute->id);
    }

    public function delete($id)
    {
        return  $this->sendResponse(AttributeSet::destroy($id) ? true : false);
    }






}
