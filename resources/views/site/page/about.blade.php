@extends('layouts.site')

<?php $title = 'О нас';?>
@section('title', $title)
@section('description', $title)
@section('keywords', $title)

@section('content')

    <div class="container">

        <?php $breadcrumb = [
            [
                'title' => 'Главная',
                'link'  => '/'
            ],
            [
                'title' => $title,
                'link'  => ''
            ]
        ];?>
        @include('includes.breadcrumb', ['breadcrumb' => $breadcrumb])

        <div id="content" style="overflow: visible;font-size:14px;">
            @include('includes.about_text')
        </div>

    </div>

@endsection