@extends('layouts.site')

@section('title',       $seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])

@section('content')

   <div class="container">

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

      <div id="content">
            <h1>{{ $seo['title'] }}</h1>
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