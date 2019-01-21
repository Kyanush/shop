@extends('layouts.mail')
@section('content')

    <div>Здравствуйте, <b>{{ $order->user->name }}</b></div>
    <br/>
    <div>Ваш заказ №<a href="{{ env('APP_URL') }}/order-history/{{ $order->id }}"> <b>{{ $order->id }}</b></a></div>
    <br/>
    <div>Статус вашего заказа: <b>{{ $order->status->name }}</b></div>

@endsection