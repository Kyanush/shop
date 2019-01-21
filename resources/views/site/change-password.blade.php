@extends('layouts.site')

<?php $title = "Смена пароля"; ?>
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
               'title' => 'Личный кабинет',
               'link'  => '/my-account'
           ],
           [
               'title' => $title,
               'link'  => ''
           ]
       ];?>
      @include('includes.breadcrumb', ['breadcrumb' => $breadcrumb])


      @include('includes.menu_left_my_account')


          <div id="content" style="overflow: visible;">
                <h1>{{ $title }}</h1>
                <form action="" method="post" enctype="multipart/form-data">
                   @csrf
                   <h2>Ваш пароль</h2>
                   <div class="content">
                      <table class="form">
                         <tbody>
                            <tr>
                                <td><span class="required">*</span> Пароль:</td>
                                <td><input type="password" name="password" value="" aria-autocomplete="list">
                                </td>
                             </tr>
                             <tr>
                                <td><span class="required">*</span> Подтвердите пароль:</td>
                                <td><input type="password" name="password_confirmation" value="">
                                </td>
                             </tr>
                         </tbody>
                      </table>
                   </div>
                   <div class="buttons">
                      <div class="left">
                          <a href="/my-account" class="button">
                              <span>Назад</span>
                          </a>
                      </div>
                      <div class="right"><input type="submit" value="Продолжить" class="button"></div>
                   </div>
                </form>
            </div>

   </div>

@endsection