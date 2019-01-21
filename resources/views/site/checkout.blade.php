@extends('layouts.site')

<?php $title = 'Оформление заказа';?>

@section('title',    	$title)
@section('description', $title)
@section('keywords',    $title)

@section('end_styles')
    <link rel="stylesheet" type="text/css" href="/site/css/simple.css">
@stop

@section('content')


<div class="container" style="position:static;">
    <div id="content" style="padding:0;background:none;">


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

        <span id="app">
            <checkout @if(Auth::check()) :_user="{{ \App\User::with('addresses')->find(Auth::user()->id) }}" @endif></checkout>
        </span>

        @section('end_scripts')
            <script src="{{ asset('js/app.js') }}"></script>
        @stop

    </div>
</div>

@endsection