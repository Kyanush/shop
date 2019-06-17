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

      <div id="content" style="overflow: visible;font-size: 14px;">
          @include('includes.delivery_payment_text')
      </div>

   </div>

@endsection