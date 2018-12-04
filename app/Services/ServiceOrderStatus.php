<?php
namespace App\Services;


use Auth;
use App\Models\OrderStatusHistory;
use App\Models\Order;


class ServiceOrderStatus
{

    public function changeStatus($order_id, $status_id)
    {
        OrderStatusHistory::create([
            'order_id'  => $order_id,
            'status_id' => $status_id,
            'user_id'   => Auth::user()->id
        ]);

        return Order::where('id', $order_id)->update(['status_id' => $status_id]) ? true : false;
    }

}