@extends('layouts.site')

@section('title', 'Onepoint.kz - главная страница')
@section('description', 'Onepoint.kz - главная страница')
@section('keywords', 'Onepoint.kz - главная страница')

@section('content')

    <div class="container">
        <div class="main_slider_main_container">

            <div class="slideshow_main_page">
                <div id="home-page-slider" class="owl-carousel-main-slider">
                    @foreach($listSlidersHomePage as $item)
                        <a class="slide_id1 be_create"  href="{{ $item->link }}">
                            <img src="{{ $item->pathImage(true) }}" alt="{{ $item->name }}">
                        </a>
                    @endforeach
                </div>
            </div>
            <script>
                $('#home-page-slider').owlCarousel({
                    singleItem: true,
                    autoPlay: 3000,
                    autoHeight: true,
                    responsive: true,
                    autoHeight: true,
                    navigation: true,
                    pagination: true,
                    stopOnHover: true,
                    lazyLoad: true,
                });
            </script>

            <div class="homepage_banner">
                @include('includes.product_day')
            </div>

        </div>




        @include('includes.product_slider', ['products' => $productsRecommend, 'title' => 'Рекомендуемое для вас'])
        @include('includes.product_slider', ['products' => $productsDiscount, 'title' => 'Акции'])
        @include('includes.product_slider', ['products' => $productsHit, 'title' => 'Хиты продаж'])
        @include('includes.product_slider', ['products' => $productsNew, 'title' => 'Новинки'])



    </div>

@endsection