@extends('layouts.mobile')

@section('title',    	 $product->name)
@section('description', $product->seo_description ? $product->seo_description : $product->name)
@section('keywords',    $product->seo_keywords    ? $product->seo_keywords    : $product->name)

@section('og_title',    	 $product->name)
@section('og_description',  $product->seo_description ? $product->seo_description : strip_tags(\App\Tools\Helpers::closeTags(\App\Tools\Helpers::limitWords($product->description, 100))))
@section('og_image',    	 env('APP_URL') . $product->pathPhoto(true))

@section('content')


    @if(empty($product_tab))
        @include('mobile.includes.topbar', ['class' => 'g-bb0 g-bg-c0', 'title' => ''])
    @elseif($product_tab == 'attributes')
        @include('mobile.includes.topbar', ['class' => '_fixed', 'title' => 'Характеристики', 'go_back' => $product->detailUrlProduct()])
    @elseif($product_tab == 'reviews')
        @include('mobile.includes.topbar', ['class' => '_fixed _fixed-top', 'title' => 'Отзывы', 'go_back' => $product->detailUrlProduct()])
    @elseif($product_tab == 'descriptions')
        @include('mobile.includes.topbar', ['class' => '_fixed', 'title' => 'Описание', 'go_back' => $product->detailUrlProduct()])
    @endif



    @if(empty($product_tab))
        @include('mobile.product.main')
    @elseif($product_tab == 'attributes')
        @include('mobile.product.attributes')
    @elseif($product_tab == 'reviews')
        @include('mobile.product.reviews')
    @elseif($product_tab == 'descriptions')
        @include('mobile.product.descriptions')
    @endif


@endsection