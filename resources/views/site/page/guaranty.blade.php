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
       <div id="content" class="information_content" style="padding: 0;">
           @include('includes.guaranty_text')
       </div>
   </div>

@endsection