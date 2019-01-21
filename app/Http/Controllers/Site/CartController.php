<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Requests\CheckoutRequest;
use App\Requests\OneClickOrderRequest;
use App\Services\ServiceCart;
use App\Services\ServiceOrder;
use App\Tools\Helpers;
use Illuminate\Http\Request;
use App\Models\Order;


class CartController extends Controller
{

    private $serviceCart;
    public function __construct(ServiceCart $serviceCart)
    {
        $this->serviceCart = $serviceCart;
    }

    public function cartSave(Request $request){
        $product_id = $request->input('product_id');
        $quantity   = $request->input('quantity', 0);

        return $this->sendResponse(
            $this->serviceCart->cartSave($product_id, $quantity)
        );
    }

    public function cartDelete($product_id){
        return $this->sendResponse(
            $this->serviceCart->cartDelete($product_id)
        );
    }

    public function cartTotal($carrier_id = 0){

        $cartTotal = $this->serviceCart->cartTotal($carrier_id);
        $cartTotal['sum'] = Helpers::priceFormat($cartTotal['sum']);

        return $this->sendResponse($cartTotal);
    }

    public function header_cart_info(){
        $total = $this->serviceCart->cartTotal();
        $total['sum'] = Helpers::priceFormat($total['sum']);

        $cartProductsList = $this->serviceCart->cartProductsList();

        return view('site.header_cart_info', [
            'total' => $total,
            'cartProductsList' => $cartProductsList
        ]);
    }

    public function checkout(){
        return view('site.checkout');
    }

    public function listCart(){
        $cartProductsList = $this->serviceCart->cartProductsList();


        $data = [];

        if($cartProductsList)
            $data = $cartProductsList->map(function ($item) {
                return [
                    'product_id'             => $item->product->id,
                    'product_name'           => $item->product->name,
                    'product_price'          => Helpers::priceFormat($item->product->price),
                    'product_specific_price' => Helpers::priceFormat($item->product->getReducedPrice()),
                    'product_url'            => $item->product->detailUrlProduct(),
                    'product_photo'          => $item->product->pathPhoto(true),
                    'quantity'               => $item->quantity,
                    'sum'                    => Helpers::priceFormat($item->quantity * $item->product->getReducedPrice())
                ];
            });


        return $this->sendResponse($data);
    }

    public function saveCheckout(CheckoutRequest $request)
    {
        //Пользователь
        $user = $this->serviceCart->findOrNewUserCart(
            $request->input('user.email'),
            $request->input('user.name'),
            $request->input('user.phone')
        );

        //адрес
        $address_id = $request->input('address.id', 0);
        if(!$address_id)
        {
            $address = $user->addresses()->create($request->input('address'));
            $address_id = $address->id;
        }

        $serviceCart  = new ServiceCart();
        $serviceOrder = new ServiceOrder();

        //заказ
        $order = new Order();
        $order->type                = 1;
        $order->user_id             = $user->id;
        $order->status_id           = 1;//новый
        $order->carrier_id          = $request->input('carrier_id');
        $order->shipping_address_id = $address_id;
        $order->comment             = $request->input('comment', '');
        $order->payment_id          = $request->input('payment_id');
        if($order->save())
        {
            //товара заказа
            foreach ($serviceCart->cartProductsList() as $item)
                $serviceOrder->productAdd($item->product_id, $order->id, $item->quantity);

            //удалить корзину
            $serviceCart->cartDeleteAll();

            $this->serviceCart->orderSendMessage($order->id);

            return $this->sendResponse(['order_id' => $order->id]);
        }

        return $this->sendResponse(false);
    }



    public function oneClickOrder(OneClickOrderRequest $request)
    {
        //Пользователь
        $user = $this->serviceCart->findOrNewUserCart(
            $request->input('email'),
            $request->input('name'),
            $request->input('phone')
        );

        //заказ
        $order = new Order();
        $order->type                = 2;
        $order->user_id             = $user->id;
        $order->status_id           = 1;//новый
        if($order->save())
        {
            $serviceOrder = new ServiceOrder();
            $serviceOrder->productAdd($request->input('product_id'), $order->id);

            $this->serviceCart->orderSendMessage($order->id);

            return $this->sendResponse(['order_id' => $order->id]);
        }
        return $this->sendResponse(false);
    }

}