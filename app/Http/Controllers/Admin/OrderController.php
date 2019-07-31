<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Callback;
use App\Models\Order;
use App\Requests\SaveOrderRequest;
use App\Tools\Helpers;
use App\User;
use App\Services\ServiceOrder;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Arr;

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
                $query->with(['status', 'user']);
            },
            'shippingAddress',
            'carrier',
            'products',
            'payment'
        ])->findOrFail($id);

        return  $this->sendResponse([
            'order'        => $order,
            'whereOrdered' => $order->whereOrdered()
        ]);
    }


    public function orderSave(SaveOrderRequest $request)
    {
        $data = $request->input('order');

        $order = Order::findOrNew($data["id"]);
        $order->fill($data);
        if($order->save())
        {
            foreach ($data['products'] as $product)
            {
                $pivot = $product['pivot'];
                if(isset($pivot['is_delete']))
                {
                    ServiceOrder::productDelete($pivot['product_id'], $order->id);
                }else{
                    ServiceOrder::productAdd($pivot['product_id'], $order->id, $pivot['quantity'], $pivot['price']);
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
        $calendar = $total_status = $total_callbacks = [];

        $start = $request->input('start');
        $end   = $request->input('end');

        $orders = Order::with('status')->filters(['created_at_start' => $start, 'created_at_end' => $end])->get();

        foreach ($orders as $item)
        {
            $calendar[] = [
                'id'    => $item->id,
                'title' => ' №' . $item->id . ', ' . Helpers::priceFormat($item->total),
                'start' => date('Y-m-d H:i:s', strtotime($item->created_at)),
                'end'   => date('Y-m-d H:i:s', strtotime($item->created_at)),
                'color' => '#b8c7ce',
                'textColor'  =>  '#222D32',
                'allDay' => false,
                'url'   => '/admin/orders/' . $item->id,
                'icon_class'  => $item->status->class,
                'icon_title'  => $item->status->name
            ];

            if(!isset($total_status[ $item->status_id ]))
                $total_status[ $item->status_id ] = [
                    'total'    => ($item->total),
                    'class'    => $item->status->class,
                    'title'    => $item->status->name,
                    'quantity' => 1
                ];
            else{
                $total_status[ $item->status_id ]['total'] += $item->total;
                $total_status[ $item->status_id ]['quantity']++;
            }
        }

        $total_status = array_values(array_sort($total_status, function($value){
            return $value['total'];
        }));


        foreach ($total_status as $k => $v)
            $total_status[$k]['total'] = Helpers::priceFormat($total_status[$k]['total']);



        $callbacks = Callback::with('status')->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->get();
        foreach ($callbacks as $item)
        {
            $calendar[] = [
                'id'    => $item->id,
                'title' => ' №' . $item->id . ', ' . $item->phone,
                'start' => date('Y-m-d H:i:s', strtotime($item->created_at)),
                'end'   => date('Y-m-d H:i:s', strtotime($item->created_at)),
                'color' => '#ffb45f',
                'textColor'  =>  '#222D32',
                'allDay' => false,
                'url'   => '/admin/callbacks/edit/' . $item->id,
                'icon_class'  => $item->status->class,
                'icon_title'  => $item->type
            ];

            if(!isset($total_callbacks[ $item->status_id ]))
                $total_callbacks[ $item->status_id ] = [
                    'class'    => $item->status->class,
                    'title'    => $item->status->name,
                    'quantity' => 1
                ];
            else{
                $total_callbacks[ $item->status_id ]['quantity']++;
            }
        }


        return  $this->sendResponse([
            'calendar'     => $calendar,
            'total_status' => $total_status,
            'total_callbacks' => $total_callbacks
        ]);
    }

    public function orderDelete($order_id){
        return  $this->sendResponse(Order::destroy($order_id));
    }

    public function newOrdersCount(){
        return  $this->sendResponse(intval(Order::new()->count()));
    }

}