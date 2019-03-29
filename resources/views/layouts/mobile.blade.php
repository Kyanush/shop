{{ \App\Tools\Helpers::generateVisitNumber() }}

<!DOCTYPE html>
<!-- saved from url=(0022)https://kaspi.kz/shop/ -->

<html lang="ru" class="js" prefix="og: http://ogp.me/ns#"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, viewport-fit=cover">


    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="yandex-verification" content="d9d1d901f0c53a09" />
    <meta name="google-site-verification" content="YOGU9Dh4gfT8os5uvRCSuQ_kwUhoUbXwqQFiNshBSHw" />
    <link rel="icon" type="image/png" href="/site/images/logo_firm.png" />


    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords"    content="@yield('keywords')">


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


    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500&amp;subset=cyrillic" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="/mobile/css/style.css?r={{rand(1, 1000000000)}}">


    <!-- swiper -->
    <link rel="stylesheet" href="/mobile/swiper/swiper.css">
    <script src="/mobile/swiper/swiper.js"></script>
    <!-- swiper -->


    <!-- Vue js -->
    <script type="text/javascript" src="/mobile/js/vue.2.6.4.js"></script>
    <script type="module">
        import Vue from 'https://cdn.jsdelivr.net/npm/vue@2.6.4/dist/vue.esm.browser.js'
    </script>
    <script type="text/javascript" src="/mobile/js/axios.min.js"></script>
    <!-- Vue js -->

    <!---- sweetalert2  ----->
    <script src="/site/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support -->
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
    <link rel="stylesheet" type="text/css" href="/site/sweetalert2/sweetalert2.min.css">
    <!---- sweetalert2  ----->

</head>


<body>

<span id="app">
    <div id="page" class="layout">
        <header class="header">
            <div class="header__inner">
            </div>
        </header>

        <div class="layout">
            <div class="wrapper">
                @yield('content')
            </div>
            @include('mobile.includes.nav')
        </div>
    </div>

    <div style="z-index: 10;">
        <div>
            <component v-bind:is="componentDialog" v-if="componentDialog"></component>
        </div>
    </div>
</span>

<script src="/global/script.js"></script>
<script type="text/javascript" src="/mobile/js/script.js?r={{rand(1, 1000000000)}}"></script>

</body>
</html>