<meta name="msvalidate.01" content="F55DDAE4472BFCE0E1078D1AD1189395" />
<meta name='wmail-verification' content='07844bf5bc650958f491165a1819df8b' />
<meta name="yandex-verification" content="d9d1d901f0c53a09" />
<meta name="google-site-verification" content="YOGU9Dh4gfT8os5uvRCSuQ_kwUhoUbXwqQFiNshBSHw" />

<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title')</title>
<meta name="description" content="@yield('description')">
<meta name="keywords"    content="@yield('keywords')">

<meta property="og:locale"       content="ru_KZ" />
<meta property="og:type"         content="website">
<meta property="og:url"          content="{{ url()->current() }}"/>
<meta property="og:site_name"    content="{{ env('APP_NAME') }}" />
<meta property="og:title"        content="@yield('title')"/>
<meta property="og:description"  content="@yield('description')"/>
<meta property="og:image"        content="@yield('og_image')"/>
<meta property="og:image:width"  content="80">
<meta property="og:image:height" content="80">

<script src="{{ asset('/site/js/jquery.min.js') }}"></script>

<!-- Vue js -->
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script type="text/javascript" src="https://unpkg.com/vue-the-mask@0.11.1/dist/vue-the-mask.js"></script>

<!-- axios -->
<script type="text/javascript" src="/site/js/axios.min.js"></script>
<script src="/global/config-axios.js"></script>
<!-- axios -->