@extends('layouts.mobile')

@section('title', 'Onepoint.kz - главная страница')
@section('description', 'Onepoint.kz - главная страница')
@section('keywords', 'Onepoint.kz - главная страница')

@section('content')

    @include('mobile.includes.topbar', ['class' => '', 'title' => $category->name])

    <div class="categories">

        @include('mobile.includes.search-bar', ['class' => 'fixed-block'])

        @include('mobile.includes.space', ['style' => 'height: 17.073vw;'])

        <div class="catalog-sub-items">
            <ul class="catalog-sub-items__list">
                @foreach($category->children()->orderBy('sort')->get() as $item)
                    <li class="catalog-sub-items__el">
                        <a href="/catalog/{{ $item->url }}" class="catalog-sub-item catalog-main">
                            <span class="catalog-sub-item__title">{{ $item->name }}</span>

                            @php
                                $items = $item->children()->orderBy('sort')->get()
                            @endphp

                            @if($items)
                                <span class="catalog-sub-item__icon catalog-sub-item__close icon icon_plus"></span>
                            @else
                                <span class="catalog-sub-item__icon icon icon_chevron"></span>
                            @endif
                        </a>
                        @if($items)
                            <ul class="catalog-sub-items__list">
                                @foreach($items as $item2)
                                    <li class="catalog-sub-items__el">
                                        <a href="/catalog/{{ $item2->url }}" class="catalog-sub-item">
                                            <span class="catalog-sub-item__title">{{ $item2->name }}</span>
                                            <span class="catalog-sub-item__icon icon icon_chevron"></span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

    </div>

@endsection