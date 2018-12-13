<?php

namespace App\Http\Controllers\Admin\Api;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Order;
use App\Requests\SaveOrderRequest;
use App\User;


use App\Services\ServiceOrder;
use Illuminate\Http\Request;
use DB;
use Auth;

class OrderController extends AdminController
{
    public function list(Request $request)
    {



        $list =  Order::with([
            'user' => function($query){
                $query->select(['id', 'name']);
                $query->withTrashed();
            },
            'status',
        ])
        ->Filters($request->all())
        ->OrderBy('id', 'DESC')
        ->paginate($request->input('perPage') ?? 10);


        return  $this->sendResponse($list);
    }

    public function view($id)
    {
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


    public function orderSave(SaveOrderRequest $request)
    {
        $data = $request->input('order');

        $serviceOrder = new ServiceOrder();

        $order = Order::findOrNew($data["id"]);
        $order->fill($data);
        if($order->save())
        {
            foreach ($data['products'] as $product)
            {
                $pivot = $product['pivot'];
                if(isset($pivot['is_delete']))
                {
                    $serviceOrder->productDelete($pivot['product_id'], $order->id);
                }else{
                    $serviceOrder->productAdd($pivot['product_id'], $order->id, $pivot['quantity'], $pivot['price']);
                }
            }
        }

        return  $this->sendResponse($order->id);
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
