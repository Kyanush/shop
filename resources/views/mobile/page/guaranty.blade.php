@extends('layouts.mobile')

<?php $title = 'Гарантия';?>
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


    @include('mobile.includes.space', ['style' => ''])
    <div class="container">
        @include('includes.guaranty_text')
    </div>

    @include('mobile.includes.footer')

@endsection