
@extends(\App\Tools\Helpers::isMobile() ? 'layouts.mobile' : 'layouts.site')

@php
    $title = 'Страница не найдена';
@endphp

@section('title',    	$title)
@section('description', $title)
@section('keywords',    $title)

@section('content')

    @if(\App\Tools\Helpers::isMobile())
        @include('mobile.includes.topbar', [
            'class'       => '_fixed',
            'title'       => $title,
            'search_show' => true,
            'menu_link'   => '',
            'menu_class'  => 'icon_menu'
        ])

        @include('mobile.includes.space', ['style' => ''])
    @endif

    <div class="error-404" style="text-align: center;padding: 40px 0;">
        <h1>Страница не найдена</h1>
        <h2 style="padding: 32px;font-size: 50px;">404</h2>
        <a href="/">Перейти на главную страницу</a>
    </div>

@endsection