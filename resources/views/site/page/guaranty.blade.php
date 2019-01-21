@extends('layouts.site')

<?php $title = 'Гарантия';?>
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

      <div id="content" style="overflow: visible;">
          Гарантия
      </div>

   </div>

@endsection