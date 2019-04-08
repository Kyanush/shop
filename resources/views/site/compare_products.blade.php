@extends('layouts.site')

<?php $title = 'Сравнение товаров';?>
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

      <div id="content">
            <h1>{{ $title }}</h1>
            @include('includes.compare-products', ['productFeaturesCompareList' => $productFeaturesCompareList])
            <div class="buttons">
                <div class="right">
                   <a href="/" class="button">
                      <span>Продолжить</span>
                   </a>
                </div>
            </div>
      </div>

   </div>

@endsection