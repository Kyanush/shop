<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class OrderStatusHistory extends Model
{

    protected $table = 'order_status_history';
    protected $fillable = [
    	'order_id',
    	'status_id',
        'user_id'
	];

	public function status()
	{
		return $this->hasOne('App\Models\OrderStatus', 'id', 'status_id');
	}

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d-m-Y H:i:s');
    }
}
