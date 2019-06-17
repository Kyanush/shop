@extends('layouts.mobile')

@section('title',    	 $seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])

@section('og_title',    	 $seo['title'])
@section('og_description',  $seo['description'])
@section('og_image',    	 env('APP_URL') . $product->pathPhoto(true))

@section('content')


    @if(empty($product_tab))
        @include('mobile.includes.topbar', [
            'class'       => 'g-bb0 g-bg-c0',
            'title'       => '',
            'search_show' => true,
            'menu_link'   => '',
            'menu_class'  => 'icon_menu'
        ])
    @elseif($product_tab == 'attributes')
        @include('mobile.includes.topbar', [
            'class'       => '_fixed',
            'title'       => 'Характеристики',
            'search_show' => true,
            'menu_link'   => $product->detailUrlProduct(),
            'menu_class'  => 'icon_back'
        ])
    @elseif($product_tab == 'reviews')
        @include('mobile.includes.topbar', [
            'class'       => '_fixed _fixed-top',
            'title'       => 'Отзывы',
            'search_show' => true,
            'menu_link'   => $product->detailUrlProduct(),
            'menu_class'  => 'icon_back'
        ])
    @elseif($product_tab == 'descriptions')
        @include('mobile.includes.topbar', [
            'class'       => '_fixed',
            'title'       => 'Описание',
            'search_show' => true,
            'menu_link'   => $product->detailUrlProduct(),
            'menu_class'  => 'icon_back'
        ])
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