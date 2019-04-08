@extends('layouts.mobile')

<?php $title = 'О нас';?>
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
        @include('includes.about_text')
    </div>

    @include('mobile.includes.footer')

@endsection