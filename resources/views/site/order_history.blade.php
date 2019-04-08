@extends('layouts.site')

<?php $title = 'Мои заказы';?>
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

                <div class="history_table">
                   <table>
                      <thead>
                      <tr>
                         <td>№ заказа</td>
                         <td>Дата</td>
                         <td>Товаров</td>
                         <td>Итого</td>
                         <td>Статус</td>
                         <td></td>
                      </tr>
                      </thead>
                      <tbody>
                         @foreach($orders as $order)
                            <tr>
                               <td>{{ $order->id }}</td>
                               <td>{{ date('d.m.Y H:i', strtotime($order->created_at))  }}</td>
                               <td>
                                  {{ $order->products_count }}
                               </td>
                               <td>
                                  {{ \App\Tools\Helpers::priceFormat($order->total) }}
                               </td>
                               <td>
                                  {{ $order->status->name }}
                               </td>
                               <td>
                                  <a href="/order-history/{{ $order->id }}">
                                     <img src="/site/images/info.png" alt="Просмотр" title="Просмотр">
                                  </a>
                               </td>
                            </tr>
                         @endforeach
                      </tbody>
                   </table>
                </div>

             <div class="buttons">
                <div class="left">
                   <a href="/my-account" class="button">
                      <span>Назад</span>
                   </a>
                </div>
             </div>


            </div>

   </div>

@endsection