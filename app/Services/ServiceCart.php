<?php
namespace App\Services;

use App\Models\Carrier;
use App\Models\Cart;
use App\Models\Order;
use App\Tools\Helpers;
use Auth;
use App\User;
use Mail;


class ServiceCart
{

    private $model;
    public function __construct()
    {
        $this->model = new Cart();
    }

    public function cartSave(int $product_id, int $quantity = 0)
    {
        $cart = $this->model::currentUser()->first();
        if(!$cart)
        {
            $data = ['visit_number' => Helpers::getVisitNumber()];
            if(Auth::check())
                $data['user_id'] = Auth::user()->id;

            $cart = $this->model::create($data);
        }

        $cartItem = $cart->cartItems->where('product_id', $product_id)->first();
        if(!$cartItem)
        {
            return $cart->cartItems()->create([
                'product_id' => $product_id,
                'quantity'   => $quantity > 0 ? $quantity : 1
            ]) ? true : false;
        }else{
            $cartItem->fill([
                'quantity'   => $quantity > 0 ? $quantity : ($cartItem->quantity + 1)
            ]);
            return $cartItem->save() ? true : false;
        }
    }

    public function cartDelete(int $product_id)
    {
        $cart = $this->model::currentUser()->first();
        $cartItem = $cart->cartItems()->where('product_id', $product_id)->first();
        if($cartItem)
        {
            if($cartItem->delete())
            {
                $cartItems = $cart->cartItems()->where('product_id', $product_id)->get();
                if(!$cartItems)
                {
                  return $cart->delete() ? true : false;
                }
                return true;
            }
        }
        return false;
    }

    public function cartTotal($carrier_id = 0)
    {
        $quantity = $sum = 0;

        $cartProductsList = $this->cartProductsList();

        foreach ($cartProductsList as $item)
        {
            $quantity += $item->quantity;
            $sum      += $item->quantity * ($item->product->specificPrice ? $item->product->getReducedPrice() : $item->product->price);
        }

        if($carrier_id > 0)
            $sum += Carrier::find($carrier_id)->price;

        return [
            'quantity' => $quantity,
            'sum'      => $sum
        ];
    }

    public function cartProductsList(){
        $cart = $this->model::currentUser()->first();
        if($cart){
            $cartItems = $cart->cartItems()->with(['product' => function($query){
                $query->with(['specificPrice' => function($query){
                    $query->dateActive();
                },
                'categories']);

            }])->get();
            return $cartItems;
        }
        return [];
    }

    public function cartDeleteAll(){
        $cart = $this->model::currentUser()->first();
        if($cart){
            $cart->cartItems()->delete();
            $cart->delete();
            return true;
        }
        return false;
    }



    public function findOrNewUserCart($email, $name, $phone){
        //Пользователь
        if(Auth::check()){
            return Auth::user();
        }else{
            $user = User::where('email', $email)->first();
            if(!$user){
                $serviceUser = new ServiceUser();
                $user = $serviceUser->createUser(
                    $email,
                    null,
                    $name,
                    $phone
                );
            }
            return $user;
        }
    }


    public function orderSendMessage($order_id){
        if(env('APP_TEST') == 0)
        {
            $order = Order::find($order_id);
            if (!$order)
                return false;

            $emails[] = env('MAIL_ADMIN');

            if($order->user->email)
                $emails[] = $order->user->email;

            $subject = env('APP_NAME') . ' - ' . 'заказ №:' . $order->id;
            Mail::send('mails.new_order', ['order' => $order, 'subject' => $subject], function($m) use($subject, $emails)
            {
                $m->to($emails)->subject($subject);
            });
        }
        return true;
    }

}