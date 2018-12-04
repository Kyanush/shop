<?php

namespace App\Http\Controllers\Admin\Api;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Carrier;
use App\Requests\SaveCarrierRequest;
use Illuminate\Http\Request;
use DB;
use App\Tools\UploadableTrait;
use File;

class CarrierController extends AdminController
{
    use UploadableTrait;

    public function list(Request $request)
    {
        $search = trim(mb_strtolower($request->input('search')));

        $list =  Carrier::where(function ($query) use ($search){

                    if(!empty($search))
                    {
                        $query->Where(   DB::raw('LOWER(name)'),          'like', "%"  . $search . "%");
                        $query->OrWhere( DB::raw('LOWER(price)'),         'like', "%"  . $search . "%");
                        $query->OrWhere( DB::raw('LOWER(delivery_text)'), 'like', "%"  . $search . "%");
                    }

                })
                ->OrderBy('ID', 'DESC')
                ->paginate($request->input('perPage') ?? 5);

        return  $this->sendResponse($list);
    }

    public function save(SaveCarrierRequest $request)
    {
        $data = $request->all();
        $data = $data['carrier'];

        $carrier = Carrier::findOrNew($data["id"]);

        if($request->file('carrier.logo'))
        {
            if($carrier->logo)
                $carrier->deleteLogo();

            $data['logo'] = $this->uploadFile($data['logo'], config('shop.carriers_path_file'));
        }
        $carrier->fill($data);

        return  $this->sendResponse($carrier->save() ? $carrier->id : false);
    }

    public function view($id)
    {
        return  $this->sendResponse(
            Carrier::findOrFail($id)
        );
    }

    public function delete($id)
    {
        return  $this->sendResponse(Carrier::destroy($id) ? true : false);
    }

}