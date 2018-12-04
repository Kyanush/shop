<?php

namespace App\Http\Controllers\Admin\Api;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Order;
use App\User;


//use App\Services\ServiceOrderStatus;
use App\Services\ServiceOrder;
use Illuminate\Http\Request;
use DB;
use Auth;

class OrderController extends AdminController
{
    public function list(Request $request)
    {
        $search = trim(mb_strtolower($request->input('search')));


        $list =  Order::with([
            'user' => function($query){
                $query->select(['id', 'name']);
                $query->withTrashed();
            },
            'status',
        ])
        ->where(function ($query) use ($search){

            if(!empty($search))
            {
                $query->Where(   DB::raw('LOWER(id)'), 'like', "%"  . $search . "%");
            }

        })
        ->OrderBy('id', 'DESC')
        ->paginate($request->input('perPage') ?? 10);


        return  $this->sendResponse($list);
    }

    public function view($id)
    {

        //ServiceOrder

        $s = new ServiceOrder;


        $s->productAdd(75, 10, 1);


        $order = Order::with([
            'user' => function($query){
                $query->withTrashed();
            },
            'status',
            'statusHistory' => function($query){
                $query->with([
                    'status' => function($query){
                        $query->select(['id', 'name', 'class']);
                    },
                    'user' => function($query){
                        $query->select(['id', 'name']);
                    }
                ]);
            },
            'shippingAddress',
            'carrier',
            'products',
            'payment'
        ])->findOrFail($id);

        return  $this->sendResponse($order);
    }




    public function users()
    {
        $list = User::select(['id', DB::raw('(concat(name,\' \',surname )) as name')])->withTrashed()
                ->with('addresses')
                ->OrderBy('id', 'DESC')
                ->get();
        return  $this->sendResponse($list);
    }


}
