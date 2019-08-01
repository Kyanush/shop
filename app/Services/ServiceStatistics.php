<?php
namespace App\Services;

use App\Models\Callback;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Tools\Helpers;
use DB;

class ServiceStatistics
{


    public static function highchartsMonthlyAmount(){
        $categories = $series = [];
        $orders_group = Order::select([DB::raw('sum(total) as total'), DB::raw('YEAR(created_at) year, MONTH(created_at) month'), 'status_id'])
            ->GroupBy(['year', 'month', 'status_id'])
            ->OrderBy('year')
            ->OrderBy('month')
            ->OrderBy('status_id')
            ->get();
        foreach ($orders_group as $k => $item)
        {

            $categories[$item->month . $item->year] = Helpers::monthName($item->month) . ' ' .  $item->year;

            if(!isset($series[ $item->status_id ]))
                $series[ $item->status_id ] = [
                    'name' => OrderStatus::find($item->status_id)->name,
                    'data' => [ intval($item->total) ]
                ];
            else
                $series[ $item->status_id ]['data'][] = intval($item->total);
        }


        $categories_new = [];
        foreach ($categories as $v)
            $categories_new[] = $v;

        $series_new = [];
        foreach ($series as $v)
            $series_new[] = $v;

        return [
            'categories' => $categories_new,
            'series'     => $series_new
        ];
    }

    public static function fullCalendar($start, $end)
    {
        $calendar = $total_orders = $total_callbacks = [];

        $orders = Order::with('status')
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<',  $end)
            ->get();

        foreach ($orders as $item)
        {
            $calendar[] = [
                'id'          => $item->id,
                'title'       => ' №' . $item->id . ', ' . Helpers::priceFormat($item->total),
                'start'       => date('Y-m-d H:i:s', strtotime($item->created_at)),
                'end'         => date('Y-m-d H:i:s', strtotime($item->created_at)),
                'color'       => '#b8c7ce',
                'textColor'   =>  '#222D32',
                'allDay'      => false,
                'url'         => '/admin/orders/' . $item->id,
                'icon_class'  => $item->status->class,
                'icon_title'  => $item->status->name
            ];

            if(!isset($total_orders[ $item->status_id ]))
                $total_orders[ $item->status_id ] = [
                    'total'     => ($item->total),
                    'class'     => $item->status->class,
                    'title'     => $item->status->name,
                    'quantity'  => 1,
                    'status_id' => $item->status_id
                ];
            else{
                $total_orders[ $item->status_id ]['total'] += $item->total;
                $total_orders[ $item->status_id ]['quantity']++;
            }
        }


        foreach ($total_orders as $k => $v)
            $total_orders[$k]['total'] = Helpers::priceFormat($total_orders[$k]['total']);



        $callbacks = Callback::with('status')
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->get();

        foreach ($callbacks as $item)
        {
            $calendar[] = [
                'id'          => $item->id,
                'title'       => ' №' . $item->id . ', ' . $item->phone,
                'start'       => date('Y-m-d H:i:s', strtotime($item->created_at)),
                'end'         => date('Y-m-d H:i:s', strtotime($item->created_at)),
                'color'       => '#ffb45f',
                'textColor'   =>  '#222D32',
                'allDay'      => false,
                'url'         => '/admin/callbacks/edit/' . $item->id,
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

        return [
            'calendar'        => $calendar,
            'total_orders'    => $total_orders,
            'total_callbacks' => $total_callbacks,
        ];
    }

}