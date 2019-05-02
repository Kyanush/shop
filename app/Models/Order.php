<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use Mail;

class Order extends Model
{



    protected $table = 'orders';
    protected $fillable = [
        'type',
        'user_id',
        'status_id',
        'carrier_id',
        'shipping_address_id',
        'comment',
        'delivery_date',
        'total',
        'payment_id',
        'paid',
        'payment_date',
        'payment_result',
        'created_at',
        'updated_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::updating(function($order) {

            if(env('APP_TEST') == 0)
            {
                if($order->status_id != self::find($order->id)->status_id && $order->status->notification != 0)
                {

                    $subject = env('APP_NAME') . ' - ' . 'заказ №:' . $order->id . ', статус вашего заказа';
                    Mail::send('mails.status_update_order', ['order' => $order, 'subject' => $subject], function ($m) use ($order, $subject) {
                        $m->to($order->user->email)->subject($subject);
                    });
                }
            }


            if($order->status_id != self::find($order->id)->status_id)
            {
                OrderStatusHistory::create([
                    'order_id'  => $order->id,
                    'status_id' => $order->status_id,
                    'user_id'   => Auth::user()->id
                ]);
            }

        });


        //Событие до
        static::Saving(function($model) {
        });


        //Событие после
        static::Created(function ($modal) {
        });


        //до
        static::deleting(function($product) {

            //история статуса
            $product->statusHistory()->delete();
            //продукты
            $product->products()->detach();
        });
    }

    public function total()
    {
        return $this->products->sum(function ($product) {
                return $product->pivot->price * $product->pivot->quantity;
            }, 0) + ($this->carrier ? $this->carrier->price : 0);
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function status()
    {
        return $this->hasOne('App\Models\OrderStatus', 'id', 'status_id');
    }

    public function statusHistory()
    {
        return $this->hasMany('App\Models\OrderStatusHistory')->orderBy('created_at', 'DESC');
    }

    public function carrier()
    {
        return $this->hasOne('App\Models\Carrier', 'id', 'carrier_id');
    }

    public function shippingAddress()
    {
        return $this->hasOne('App\Models\Address', 'id', 'shipping_address_id');
    }

    public function payment()
    {
        return $this->hasOne('App\Models\Payment', 'id', 'payment_id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withPivot(['name', 'sku', 'price', 'quantity']);
    }


    public function convertArr($v){
        return is_array($v) ? $v : [$v];
    }

    public function scopeFilters($query, $filter)
    {
        if(isset($filter['id']))
            $query->WhereIn('id', $this->convertArr($filter['id']));

        if(isset($filter['user_id']))
            $query->WhereIn('user_id', $this->convertArr($filter['user_id']));

        if(isset($filter['type']))
            $query->WhereIn('type', $this->convertArr($filter['type']));

        if(isset($filter['status_id']))
            $query->WhereIn('status_id', $this->convertArr($filter['status_id']));

        if(isset($filter['carrier_id']))
            $query->WhereIn('carrier_id', $this->convertArr($filter['carrier_id']));

        if(isset($filter['shipping_address_id']))
            $query->WhereIn('shipping_address_id', $this->convertArr($filter['shipping_address_id']));

        if(isset($filter['comment']))
            $query->Where(   DB::raw('LOWER(comment)'), 'like', "%"  . $filter['comment'] . "%");


        if(isset($filter['delivery_date_start']))
            $query->whereDate('delivery_date', '>=', $filter['delivery_date_start']);
        if(isset($filter['delivery_date_end']))
            $query->whereDate('delivery_date', '<=', $filter['delivery_date_end']);

        if(isset($filter['total']))
            $query->Where(   DB::raw('LOWER(total)'), 'like', "%"  . $filter['total'] . "%");

        if(isset($filter['payment_id']))
            $query->WhereIn('payment_id', $this->convertArr($filter['payment_id']));

        if(isset($filter['paid']))
            $query->WhereIn('paid', $this->convertArr($filter['paid']));


        if(isset($filter['payment_date_start']))
            $query->whereDate('payment_date', '>=', $filter['payment_date_start']);
        if(isset($filter['payment_date_end']))
            $query->whereDate('payment_date', '<=', $filter['payment_date_end']);


        if(isset($filter['created_at_start']))
            $query->whereDate('created_at', '>=', $filter['created_at_start']);
        if(isset($filter['created_at_end']))
            $query->whereDate('created_at', '<=', $filter['created_at_end']);


        return $query;
    }


    public function scopeNew($query){
        return $query->where('status_id', 1);
    }

}
