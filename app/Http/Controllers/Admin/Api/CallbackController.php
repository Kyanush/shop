<?php

namespace App\Http\Controllers\Admin\Api;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Callback;
use Illuminate\Http\Request;

class CallbackController extends AdminController
{
    public function list(Request $request)
    {
        $list =  Callback::search($request->input('search'))
            ->OrderBy('id', 'DESC')
            ->paginate($request->input('perPage', 10));

        return  $this->sendResponse($list);
    }

    public function delete($id)
    {
        return  $this->sendResponse(Callback::destroy($id) ? true : false);
    }

}
