<?php

namespace App\Http\Controllers\Admin\Api;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Order;
use App\Requests\SaveOrderRequest;
use App\Tools\Helpers;
use App\User;
use App\Services\ServiceOrder;
use Illuminate\Http\Request;
use DB;

class OrderController extends AdminController
{
    public function list(Request $request)
    {
        $list =  Order::with([
            'user' => function($query){
                $query->select(['id', 'name']);
            },
            'status',
        ])
        ->Filters($request->all())
        ->OrderBy('id', 'DESC')
        ->paginate($request->input('perPage', 10));

        return  $this->sendResponse($list);
    }

    public function view($id)
    {
        $order = Order::with([
            'user',
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
        $users = User::with('addresses')->OrderBy('id', 'DESC')->get();

        $data = $users->map(function ($item) {
            return [
                'id'        => $item->id,
                'name'      => $item->name . ' ' . $item->surname,
                'addresses' => $item->addresses
            ];
        });

        return  $this->sendResponse($data);
    }

    public function calendarOrders(Request $request)
    {
        $data  = [];

        $start = $request->input('start');
        $end   = $request->input('end');

        $orders = Order::with('status')->filters(['created_at_start' => $start, 'created_at_end' => $end])->get();

        foreach ($orders as $item)
        {
            $data[] = [
                'id'    => $item->id,
                'title' => ' №' . $item->id . ', ' . Helpers::priceFormat($item->total),
                'start' => date('Y-m-d H:i:s', strtotime($item->created_at)),
                'end'   => date('Y-m-d H:i:s', strtotime($item->created_at)),
                'color' => '#222D32',
                'allDay' => false,
                'icon'  => $item->status->class,
                'url'   => '/admin/orders/' . $item->id,
                'description' => 'my test event'
            ];

            /*
            $minutes = 40;
            $data[] = [
                'title' => date('H:i', strtotime($item->created_at)),
                'resourceId' => $item->visitor_id,
                'icon' => 'fa fa-cutlery',
                'start' => date('Y-m-d H:i:s', strtotime($item->created_at)),
                'end'   => date('Y-m-d H:i:s', (strtotime($item->created_at) + ($minutes * 60)))
            ];

            $data[] = [
                'title'      =>  $item->nutritionTime->name . ' ' . date('H:i', strtotime($item->nutritionTime->start)) . ' - ' . date('H:i', strtotime($item->nutritionTime->end)),
                'resourceId' => $item->visitor_id,
                'start'      => date('Y-m-d', strtotime($item->created_at)) . ' ' . date('H:i:s', strtotime($item->nutritionTime->start)),
                'end'        => date('Y-m-d', strtotime($item->created_at)) . ' ' . date('H:i:s', strtotime($item->nutritionTime->end)),
                'color'      =>  '#a5a5a5',
                'textColor'  =>  '#fff',
                'rendering'  => 'background',
            ];*/
        }




        return  $this->sendResponse($data);
    }

}