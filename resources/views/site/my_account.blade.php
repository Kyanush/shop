@extends('layouts.site')

<?php $title = "Личный кабинет"; ?>
@section('title', $title)
@section('description', $title)
@section('keywords', $title)

@section('content')

   <div class="container">

       <?php $breadcrumbs = [
           [
               'title' => 'Главная',
               'link'  => '/'
           ],
           [
               'title' => $title,
               'link'  => ''
           ]
       ];?>
      @include('includes.breadcrumb', ['breadcrumbs' => $breadcrumbs])

      @include('includes.menu_left_my_account')

      <div id="content" style="background: none; padding: 0px; overflow: visible;">
         <h1>{{ $title }}</h1>
         <div class="account_header_info">

            <div class="account_header_info_left">
               <div class="account_header_info_line">
                  <div class="account_header_info_line_left"><span>Имя:</span></div>
                  <div class="account_header_info_line_right">{{ $user->name }}<a href="/account-edit">изменить</a></div>
               </div>
               <div class="account_header_info_line">
                  <div class="account_header_info_line_left"><span>E-mail:</span></div>
                  <div class="account_header_info_line_right">{{ $user->email }}<a href="/account-edit">изменить</a></div>
               </div>
               <div class="account_header_info_line">
                  <div class="account_header_info_line_left"><span>Телефон:</span></div>
                  <div class="account_header_info_line_right">{{ $user->phone }}<a href="/account-edit">изменить</a></div>
               </div>
            </div>

            <!--
            <div class="account_header_info_right">
               <div class="account_header_kitbonus">
                  Количество MI-бонусов: <span>100 <a href="https://ru-mi.com/mibonus">хочешь MI-бонусы?</a></span>
               </div>
               <div class="account_header_state">
                  Статус: <a href="https://ru-mi.com/mibonus">Стальной</a>
               </div>
               <div class="account_header_progress">
                  <div class="account_header_progress_full" style="width: 112px;"></div>
                  <div class="account_header_progress_zero_text">0</div>
                  <div class="account_header_progress_first_text">0</div>
                  <div class="account_header_progress_second_text">50 000</div>
                  <div class="account_header_progress_third_text">150 000</div>
               </div>
            </div>-->
         </div>
         <div class="account_blocks">
            <a href="/order-history" class="account_block account_block_1">История заказов</a>
            <a href="/account-edit" class="account_block account_block_2">Личные данные</a>
            <!--<a href="https://ru-mi.com/index.php?route=account/bonus" class="account_block account_block_3">Мои бонусы</a>--->
            <a href="/checkout" class="account_block account_block_4">Корзина</a>
            <!--<a href="/newsletter" class="account_block account_block_5">Подписки</a>--->
            <a href="/contact" class="account_block account_block_7">Контакты</a>
         </div>
         </div>
   </div>

@endsection