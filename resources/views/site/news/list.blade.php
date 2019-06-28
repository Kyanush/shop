@extends('layouts.site')

@section('title',       'Новости')
@section('description', 'Новости о компании '. env('APP_NO_URL'))
@section('keywords',    'Новинки, Обзоры, Сравнения')

@section('content')

    <div class="container">

        @include('includes.breadcrumb', ['breadcrumbs' => [
           [
               'title' => 'Главная',
               'link'  => '/',
           ],
           [
               'title' => 'Новости',
               'link'  => ''
           ]
       ]])

        <h1>
            Новости
        </h1>

        <div id="news">

            <div class="news_list">

                @foreach($news as $item)
                    <div class="news_item">
                        <div class="left">
                            <a href="{{ $item->detailUrl() }}">
                                <img src="{{ $item->pathImage(true) }}"
                                     class="lazyload"
                                     title="{{ $item->title }}"
                                     alt="{{ $item->title }}"/>
                            </a>
                        </div>
                        <div class="right">
                            <a href="{{ $item->detailUrl() }}" class="title">
                                {{ $item->title }}
                            </a>
                            <div class="description">
                                {!! $item->preview_text !!}
                            </div>
                            <div class="date">
                                {{ \App\Tools\Helpers::ruDateFormat($item->created_at) }}
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            {!! $news->links("pagination::default") !!}

        </div>
    </div>

@endsection