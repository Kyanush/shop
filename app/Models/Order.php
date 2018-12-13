<?php

namespace App\Models;

//use App\Mail\NotificationTemplateMail;
use App\Models\OrderStatusHistory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Order extends Model
{



    protected $table = 'orders';
    protected $fillable = [
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
    /*
        public $notificationVars = [
            'userSalutation',
            'userName',
            'userEmail',
            'carrier',
            'total',
            'status'
        ];
    */
    /*
    |--------------------------------------------------------------------------
    | NOTIFICATIONS VARIABLES
    |--------------------------------------------------------------------------
    */
    /*
    public function notificationVariables()
    {
        return [
            'userSalutation' => $this->user->salutation,
            'userName'       => $this->user->name,
            'userEmail'      => $this->user->email,
            'total'          => $this->total(),
            'carrier'        => $this->carrier()->first()->name,
            'status'         => $this->status->name
        ];
    }
*/
    /*
    |--------------------------------------------------------------------------
    | EVENTS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();

        static::updating(function($order) {
            /*
            // Send notification when order status was changed
            $oldStatus = $order->getOriginal();
            if ($order->status_id != $oldStatus['status_id'] && $order->status->notification != 0) {
                // example of usage: (be sure that a notification template mail with the slug "example-slug" exists in db)
                return \Mail::to($order->user->email)->send(new NotificationTemplateMail($order, "order-status-changed"));
            }
*/
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
    }

    public function total()
    {
        return $this->products->sum(function ($product) {
                return $product->pivot->price * $product->pivot->quantity;
            }, 0) + $this->carrier->price;
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
        return $this->belongsToMany('App\Models\Product')->withPivot(['name', 'sku', 'price', 'quantity'])->withTrashed();
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


    /*
        public function getCreatedAtAttribute($value)
        {
            return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d-m-Y H:i:s');
        }
        public function getUpdatedAtAttribute($value)
        {
            return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d-m-Y H:i:s');
        }*/


}
