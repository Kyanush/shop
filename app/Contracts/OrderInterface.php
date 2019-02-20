<?php

namespace App\Contracts;

interface OrderInterface
{
    public function productDelete($product_id, $order_id);
    public function productAdd($product_id, $order_id, $quantity = 1, $price = 0);
    public function totalOrder($order_id);
    public function orderSendMessage($order_id);
}