@extends('layouts.site')

@section('title',       $seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])

@section('content')

    <div class="container">
        <div class="main_slider_main_container">

            <div class="slideshow_main_page">
                <div id="home-page-slider" class="owl-carousel-main-slider">
                    @foreach($listSlidersHomePage as $item)
                        <a class="slide_id1 be_create"  href="{{ $item->link }}">
                            <img style="
    max-height: 410px;
    max-width: 100%;
    margin: 0 auto;
    display: block;
" src="{{ $item->pathImage(true) }}" alt="{{ $item->name }}">
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


        @include('includes.product_slider', ['products' => $productsDiscount, 'title' => 'Акции'])
        @include('includes.product_slider', ['products' => $products1, 'title' => 'Redmi Note 8 Pro'])
        @include('includes.product_slider', ['products' => $products2, 'title' => 'Redmi Note 8'])


        <br/><br/>
        @include('site.news.slider', ['news' => $news])


        <div class="welcome">
            <div class="welcome_left">
                <div class="welcome_text">

                    <h1>{{ env('APP_NO_URL') }} — интернет-магазин смартфонов, гаджетов и ноутбуков</h1>

                    <p>
                        Вы предпочитаете покупать исключительно качественную электронную технику, имеющую все необходимые сертификаты? Значит,
                        магазин «{{env('APP_NO_URL')}}» – то, что вам нужно! Мы рады приветствовать на этом сайте каждого покупателя и готовы
                        предложить вам только подлинные устройства популярных брендов.
                    </p>

                    <h2>Наши преимущества</h2>

                    <ol>
                        <li>Качественный товар с гарантией</li>
                        <li>Адекватные цены без огромных и необоснованных накруток.</li>
                        <li>Большой выбор техники.</li>
                        <li>Своевременная доставка по городу с помощью опытных курьеров.</li>
                        <li>Грамотная консультация менеджеров</li>
                        <li>Быстрое оформление заказов.</li>
                    </ol>

                    <p>
                        Мы не продаём товары и не организовываем их доставку, мы работаем для того, чтобы покупатель мог быстро и удобно найти самое выгодное предложение.
                        Для тех, кто определяется с выбором, в каждом разделе есть подбор по параметрам и возможность сравнить товары между собой.
                        Доступен и удобный текстовый поиск, позволяющий искать как нужные разделы, так и конкретные товары по названию.
                        А на странице каждой модели есть подробная информация, которая поможет принять решение: описание, технические характеристики,
                        фото и видео, полезные ссылки и отзывы.
                    </p>
                </div>
            </div>
        </div>

    </div>

@endsection