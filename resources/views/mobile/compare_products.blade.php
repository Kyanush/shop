@extends('layouts.mobile')

<?php $title = 'Сравнение товаров';?>
@section('title', $title)
@section('description', $title)
@section('keywords', $title)

@section('content')

    @include('mobile.includes.topbar', [
        'class'       => '_fixed',
        'title'       => '<a class="topbar__heading-link"><i class="topbar__heading-logo _icon"></i>' . $title . '</a>',
        'search_show' => false
    ])
    @include('mobile.includes.space', ['style' => 'height: 3.073vw;'])

    <div class="container">
        @include('includes.compare-products', ['productFeaturesCompareList' => $productFeaturesCompareList])
    </div>

    @include('mobile.includes.footer')

@endsection