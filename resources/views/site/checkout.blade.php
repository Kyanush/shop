@extends('layouts.site')

@section('title',       $seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])

@section('end_styles')
    <link rel="stylesheet" type="text/css" href="/site/css/simple.css">
@stop

@section('content')


<div class="container" style="position:static;">
    <div id="content" style="padding:0;background:none;">


        <?php $breadcrumbs = [
            [
                'title' => 'Главная',
                'link'  => '/'
            ],
            [
                'title' => $seo['title'],
                'link'  => ''
            ]
        ];?>
        @include('includes.breadcrumb', ['breadcrumbs' => $breadcrumbs])

        <span id="app">
            <checkout @if(Auth::check()) :_user="{{ \App\User::with('addresses')->find(Auth::user()->id) }}" @endif></checkout>
        </span>

        @section('end_scripts')
            <script src="{{ asset('js/app.js') }}?r={{ rand() }}"></script>
        @stop

    </div>
</div>

@endsection