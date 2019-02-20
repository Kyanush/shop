<?php

namespace App\Contracts;

interface CartInterface
{
    public function cartSave(int $product_id, int $quantity = 0);
    public function cartDelete(int $product_id);
    public function cartTotal($carrier_id = 0);
    public function cartProductsList();
    public function cartDeleteAll();
}