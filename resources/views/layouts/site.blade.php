@php
    $currentCity = \App\Services\ServiceCity::getCurrentCity();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords"    content="@yield('keywords')">



    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="initial-scale=1.0,width=device-width">

    <meta property="og:locale"       content="ru_KZ" />
    <meta property="og:type"         content="website">
    <meta property="og:url"          content="{{ url()->current() }}"/>
    <meta property="og:site_name"    content="{{ env('APP_NAME') }}" />
    <meta property="og:title"        content="@yield('og_title')"/>
    <meta property="og:description"  content="@yield('og_description')"/>
    <meta property="og:image"        content="@yield('og_image')"/>
    <meta property="og:image:width"  content="80">
    <meta property="og:image:height" content="80">

    <script type="text/javascript" src="/site/js/jquery-3.3.1.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="/site/css/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="/site/css/style.css">

    <!---- es  ----->
    <script type="text/javascript" src="/site/js/es.js"></script>
    <!---- es  ----->


    <!---- sweetalert2  ----->
    <script src="/site/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support -->
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
    <link rel="stylesheet" type="text/css" href="/site/sweetalert2/sweetalert2.min.css">
    <!---- sweetalert2  ----->


    <!-- carousel --->
    <link rel="stylesheet" type="text/css" href="/site/carousel/owl.carousel.css"/>
    <script type="text/javascript" src="/site/carousel/owl.carousel-min.js"></script>
    <!-- carousel --->


    <!-- slick js --->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://kenwheeler.github.io/slick/slick/slick-theme.css"/>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <!-- slick js --->

    <!-- axios -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="/global/config-axios.js"></script>
    <!-- axios -->

    @if(env('APP_NO_URL') == 'ShopX.kz')
        <meta name="msvalidate.01" content="FA2FCEE563AF49653FFF42334E7092CC" />
        <meta name='wmail-verification' content='c74818c22574ac605627147e0e2b3938' />
        <meta name="yandex-verification" content="c53e2b353e1786fd" />
        <meta name="google-site-verification" content="lIuokO3B8NA53x6eSCa44i-eQSaIeWhj99_76Dl-OyM" />
    @endif

    @if(env('APP_NO_URL') == 'OnePoint.kz')
        <meta name="msvalidate.01" content="F55DDAE4472BFCE0E1078D1AD1189395" />
        <meta name='wmail-verification' content='07844bf5bc650958f491165a1819df8b' />
        <meta name="yandex-verification" content="d9d1d901f0c53a09" />
        <meta name="google-site-verification" content="YOGU9Dh4gfT8os5uvRCSuQ_kwUhoUbXwqQFiNshBSHw" />
    @endif

    @yield('add_in_head')

    @include('schemas.business')
    @include('schemas.organization')
    @yield('schemas_breadcrumb')
    @yield('schemas_product')

</head>
<body>


<!-- не удалить меню --->
<div class="grey_bg" style="display: none;"></div>
<!-- не удалить меню --->

@include('site.includes.header')
@yield('content')
@include('site.includes.bottom_rumi')
@include('site.includes.mail_bottom')
@include('site.includes.footer')
@include('site.includes.select-city')
@include('site.includes.callback')


<!-- product slider --->
<link rel="stylesheet" type="text/css" href="/site/product_slider/style.css"/>
<script type="text/javascript" src="/site/product_slider/script.js"></script>
<!-- product slider --->

@yield('add_in_end')

<!-- jquery-ui --->
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<link href="https://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
<!-- jquery-ui --->

<!-- slick js --->
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://kenwheeler.github.io/slick/slick/slick-theme.css"/>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<!-- slick js --->

@include('includes.analytics')

<!-- Mask --->
<script type="text/javascript" src="/site/js/jquery.maskedinput.min.js"></script>
<!-- Mask --->

<script src="/global/script.js"></script>
<script src="/site/js/script.js"></script>

<!--- Не удалить --->
<div id="card-success-popup" style="display: none"></div>
<!--- Не удалить --->

</body>
</html>
