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
               'title' => 'Личный кабинет',
               'link'  => '/my-account'
           ],
           [
               'title' => $seo['title'],
               'link'  => ''
           ]
       ];?>
      @include('includes.breadcrumb', ['breadcrumbs' => $breadcrumbs])


      @include('includes.menu_left_my_account')

          <div id="content" style="overflow: visible;">
                <h1>{{ $seo['title'] }}</h1>
                @auth
                      @if(count($wishlist) == 0)
                         <p>У Вас нет закладок</p>
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
                                              <a href="{{ route('wishlist_delete', ['product_id' => $item->product_id]) }}">
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
                @else
                      <p>Пожалуйста, авторизуйтесь.</p>
                @endguest
          </div>

   </div>

@endsection