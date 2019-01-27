<?php
namespace App\Services;

use App\Models\Order;
use App\Models\Product;

class ServiceOrder
{

    private $model;
    public function __construct()
    {
        $this->model = new Order();
    }



    public function productDelete($product_id, $order_id)
    {
        $order = $this->model::find($order_id);
        $order->products()->detach($product_id);
        $this->totalOrder($order_id);
        return true;
    }

    public function productAdd($product_id, $order_id, $quantity = 1, $price = 0)
    {
        $product = Product::with(['specificPrice' => function($query){
            $query->DateActive();
        }])->find($product_id);

        if($product)
        {
            if($price == 0)
            {
                if($product->specificPrice)
                    $price = $product->getReducedPrice();
                else
                    $price = $product->price;
            }

            //findOrNew
            $order = $this->model::find($order_id);

            $order->products()->syncWithoutDetaching([$product_id =>
                [
                    'name'     => $product->name,
                    'sku'      => $product->sku,
                    'price'    => $price,
                    'quantity' => $quantity
                ]
            ]);

            $this->totalOrder($order_id);
        }else{
            return false;
        }
    }

    public function totalOrder($order_id)
    {
        $order = $this->model::find($order_id);
        $order->total = $order->total();
        return $order->save();
    }

}