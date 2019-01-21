@extends('layouts.site')

<?php $title = 'Мои закладки';?>
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

          <div id="content" style="overflow: visible;">  <h1>Мои закладки</h1>
             @if(count($wishlist) == 0)
                У Вас нет закладок
             @else
                <div class="wishlist-info">
                   <table>
                      <thead>
                      <tr>
                         <td class="image">Изображение</td>
                         <td class="name">Наименование товара</td>
                         <td class="model">Артикул</td>
                         <td class="stock">Наличие</td>
                         <td class="price">Цена</td>
                         <td class="action">Действие</td>
                      </tr>
                      </thead>
                      <tbody id="wishlist-row4380">
                            @foreach($wishlist as $item)
                               <tr>
                                  <td class="image">
                                     <a href="{{ $item->product->detailUrlProduct() }}">
                                        <img src="{{ $item->product->pathPhoto(true) }}"
                                             alt="{{ $item->product->name }}"
                                             title="{{ $item->product->name }}">
                                     </a>
                                  </td>
                                  <td class="name">
                                     <a href="{{ $item->product->detailUrlProduct() }}">
                                        {{ $item->product->name }}
                                     </a>
                                  </td>
                                  <td class="model">
                                     {{ $item->product->sku }}
                                  </td>
                                  <td class="stock">
                                     {{ $item->product->stock > 0 ? 'В наличии' : 'Нет в наличии' }}
                                  </td>
                                  <td class="price">
                                     <div class="price">
                                        @if($item->product->specificPrice)
                                           <s>{{ \App\Tools\Helpers::priceFormat($item->product->price) }}</s>
                                        @endif
                                        <b>
                                           {{ \App\Tools\Helpers::priceFormat($item->product->getReducedPrice()) }}
                                        </b>
                                     </div>
                                  </td>
                                  <td class="action">
                                     <a href="/wishlist-delete/{{ $item->product_id }}">
                                        <img src="/site/images/remove.png" alt="Удалить" title="Удалить">
                                     </a>
                                  </td>
                               </tr>
                            @endforeach
                      </tbody>

                   </table>
                </div>
             @endif
             <div class="buttons">
                <div class="right">
                   <a href="/my-account" class="button">
                      <span>Продолжить</span>
                   </a>
                </div>
             </div>
            </div>

   </div>

@endsection