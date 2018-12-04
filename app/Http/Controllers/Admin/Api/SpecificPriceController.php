<?php

namespace App\Http\Controllers\Admin\Api;
use App\Http\Controllers\Admin\AdminController;

use App\Models\SpecificPrice;
use Illuminate\Http\Request;
use DB;

class SpecificPriceController extends AdminController
{
    public function list(Request $request)
    {
        $search = trim(mb_strtolower($request->input('search')));

        $list =  SpecificPrice::with(['product' => function($query){

            $query->select(['id', 'name', 'price']);

        }])->where(function ($query) use ($search){
                if(!empty($search))
                {
                    $query->whereHas('product', function($query) use ($search){
                        $query->Where(DB::raw('LOWER(name)'), 'like', "%"  . $search . "%");
                    });
                }
        })
        ->OrderBy('id', 'DESC')
        ->paginate($request->input('perPage') ?? 5);

        foreach ($list as $key => $item)
        {
            $list[$key]->setAttribute('reduced_price', $item->getReducedPrice());
        }

        return  $this->sendResponse($list);
    }

    public function delete($id)
    {
        return  $this->sendResponse(SpecificPrice::destroy($id) ? true : false);
    }

}
