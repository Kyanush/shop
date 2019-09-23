@extends('layouts.site')

<?php $title = 'Заказ №:' . $order->id;?>
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
               'title' => 'Личный кабинет',
               'link'  => '/my-account'
           ],
           [
               'title' => 'История заказов',
               'link'  => '/order-history'
           ],
           [
               'title' => $title,
               'link'  => ''
           ]
       ];?>

      @include('includes.breadcrumb', ['breadcrumbs' => $breadcrumbs])

      @include('includes.menu_left_my_account')




          <div id="content">

             <h1>{{ $title }}</h1>

             <div class="history_table">
                <table class="list">
                   <thead>
                   <tr>
                      <td class="left" colspan="2">Детали заказа</td>
                   </tr>
                   </thead>
                   <tbody>
                         <tr>
                               <td class="left" style="width: 50%;">
                                  <b>Статус заказа::</b> {{ $order->status->name ?? 'Нет' }}<br>
                                  <b>Способ оплаты::</b> {{ $order->payment->name ?? 'Нет'}}
                               </td>
                         </tr>
                         <tr>
                            <td class="left" style="width: 50%;">
                               <b>Дата заказа:</b> {{ date('d.m.Y H:i', strtotime($order->created_at))  }}<br>
                               <b>Комментарий к заказу:</b>   {{ $order->comment ? $order->comment : 'Нет' }}
                            </td>
                         </tr>
                         <tr>
                               <td class="left" style="width: 50%;">
                                  <b>Оплачен:</b>  {{ $order->paid == 1 ? 'Да' : 'Нет'}}<br>
                                  <b>Дата оплаты:</b>  {{ $order->payment_date ? date('d.m.Y H:i', strtotime($order->payment_date)) : 'Нет' }}
                               </td>
                               <td class="left" style="width: 50%;">
                               </td>
                         </tr>
                   </tbody>
                </table>
             </div>
             <div class="history_table">
                <table class="list">
                   <thead>
                      <tr>
                         <td class="left">Доставка:</td>
                      </tr>
                   </thead>
                   <tbody>
                      <tr>
                         <td class="left">
                            @if(isset($order->carrier))
                                  {{ $order->carrier->name }}, {{ \App\Tools\Helpers::priceFormat($order->carrier->price) }}
                            @endif
                            <br/>
                            <b>Адрес доставки:</b> {{ $order->city }}, {{ $order->address}}
                         </td>
                      </tr>
                   </tbody>
                </table>
             </div>
             <div class="history_table">
                <table class="list">
                   <thead>
                   <tr>
                      <td class="left">Наименование товара</td>
                      <td class="right">Количество</td>
                      <td class="right">Цена</td>
                      <td class="right">Итого</td>
                   </tr>
                   </thead>
                   <tbody>
                       @foreach($order->products as $product)
                            <tr>
                               <td class="left">
                                  <a href="{{ $product->detailUrlProduct() }}">
                                       {{ $product->pivot->name }}
                                  </a>
                               </td>
                               <td class="right">
                                  {{ $product->pivot->quantity }}
                               </td>
                               <td class="right">
                                  {{ \App\Tools\Helpers::priceFormat($product->pivot->price) }}
                               </td>
                               <td class="right">
                                  {{ \App\Tools\Helpers::priceFormat($product->pivot->quantity * $product->pivot->price) }}
                               </td>
                            </tr>
                       @endforeach
                   </tbody>
                   <tfoot>
                      <tr>
                         <td colspan="2"></td>
                         <td class="right"><b>Доставка @if(isset($order->carrier))({{ $order->carrier->name }})@endif:</b></td>
                         <td class="right">
                            @if(isset($order->carrier))
                               {{ \App\Tools\Helpers::priceFormat($order->carrier->price) }}
                            @endif
                         </td>
                      </tr>
                      <tr>
                         <td colspan="2"></td>
                         <td class="right"><b>Итого:</b></td>
                         <td class="right">{{ \App\Tools\Helpers::priceFormat($order->total) }}</td>
                      </tr>
                   </tfoot>
                </table>
             </div>

             <?php $statusHistories = $order->statusHistory()->OrderBy('id', 'DESC')->get(); ?>

             @if(count($statusHistories) > 0)
                   <h2>История заказов</h2>
                   <div class="history_table">
                      <table class="list">
                         <thead>
                            <tr>
                               <td class="left">Дата</td>
                               <td class="left">Статус</td>
                            </tr>
                         </thead>
                         <tbody>
                            @foreach($statusHistories as $statusHistory)
                               <tr>
                                  <td class="left">
                                     {{ date('d.m.Y H:i', strtotime($statusHistory->created_at))  }}
                                  </td>
                                  <td class="left">
                                     {{ $statusHistory->status->name }}
                                  </td>
                               </tr>
                            @endforeach
                         </tbody>
                      </table>
                   </div>
             @endif

             <div class="buttons">
                <div class="left">
                   <a href="/order-history/" class="button">
                      <span>Назад</span>
                   </a>
                </div>
             </div>
          </div>
   </div>
@endsection
