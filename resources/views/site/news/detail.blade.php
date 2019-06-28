@extends('layouts.site')

@section('title',       $news->title )
@section('description', $news->preview_text)
@section('keywords',    '')

@section('content')

    <div class="container">

        @include('includes.breadcrumb', ['breadcrumbs' => [
           [
               'title' => 'Главная',
               'link'  => '/',
           ],
           [
               'title' => 'Новости',
               'link'  => route('news_list')
           ],
           [
               'title' => $news->title,
               'link'  => ''
           ]
       ]])

        <h1>
            {{ $news->title }}
        </h1>

        <div id="news">
            <p>{{ \App\Tools\Helpers::ruDateFormat($news->created_at) }}</p>
            {!! $news->detail_text !!}
        </div>
    </div>

@endsection