<?php

namespace App\Http\Controllers\Admin\Api;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Tax;

class TaxController extends AdminController
{

    public function list()
    {
        return  $this->sendResponse(
            Tax::all()
        );
    }

}