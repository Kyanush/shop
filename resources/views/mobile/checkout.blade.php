@extends('layouts.mobile')

<?php $title = 'Оформление заказа';?>

@section('title',    	$title)
@section('description', $title)
@section('keywords',    $title)

@section('content')

    @include('mobile.includes.topbar', [
                'class'       => '_fixed',
                'title'       => '<a class="topbar__heading-link"><i class="topbar__heading-logo _icon"></i>Магазин</a>',
                'search_show' => false
            ])
    @include('mobile.includes.space', ['style' => 'height: 3.073vw;'])

    <div class="mount-checkout-spa">
        <checkout></checkout>
    </div>

    @include('mobile.includes.footer')

@endsection