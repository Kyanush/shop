@extends('layouts.site')

@section('title',    	$seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])
@section('og_image',    env('APP_URL') . $product->pathPhoto(true))

@section('content')

    @include('schemas.product', [
        'product'          => $product,
        'group_products'   => $group_products,
        'category'         => $category
    ])

    <div class="container" style="position:static;"  itemtype="http://schema.org/Product" itemscope>

        @include('includes.breadcrumb', ['breadcrumbs' => $breadcrumbs])

        <div id="product-info-parent">
            <div id="content" style="margin-bottom: 0;">



                <div class="product-info">
                    <div class="left">

                        <div class="stickers">
                            @if($product->specificPrice)
                                <div class="product_sticker_special">
                                    {{ $product->getDiscountTypeinfo() }}
                                </div>
                            @endif
                            @foreach($product->attributes as $attribute)
                                @if($attribute->id == 49 and $attribute->pivot->value)

                                    @if($attribute->pivot->value == 'Хит')
                                        <div class="product_sticker_hit"><span>Хит</span></div>
                                    @endif
                                    @if($attribute->pivot->value == 'New!')
                                        <div class="product_sticker_new">New!</div>
                                    @endif

                                @endif
                            @endforeach
                        </div>

                        <div class="left_image">

                            <div class="product-images-main">
                                <div class="item">
                                    <img itemprop="image" data-lazy="{{ $product->pathPhoto(true) }}" title="{{ $product->name }}" alt="{{ $product->name }}"/>
                                </div>
                                @foreach($product->images as $image)
                                    <div class="item">
                                        <img itemprop="image" data-lazy="{{ $image->imagePath(true) }}" title="{{ $product->name }}" alt="{{ $product->name }}"/>
                                    </div>
                                @endforeach
                            </div>

                            @if(count($product->images) > 0)
                                <div class="product-images-nav">
                                    <div class="item">
                                        <img data-lazy="{{ $product->pathPhoto(true) }}"
                                             title="{{ $product->name }}"
                                             alt="{{ $product->name }}">
                                    </div>
                                    @foreach($product->images as $image)
                                        <div class="item">
                                            <img data-lazy="{{ $image->imagePath(true) }}"
                                                 title="{{ $product->name }}"
                                                 alt="{{ $product->name }}">
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                        </div>

                        <script>
                            /** Слайдер товара **/
                            $('.product-images-main').slick({
                                lazyLoad: 'ondemand',
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                arrows: false,
                                fade: true,
                                asNavFor: '.product-images-nav'
                            });
                            $('.product-images-nav').slick({
                                lazyLoad: 'ondemand',
                                slidesToShow: window.screen.availWidth > 830 ? 4 : 3,
                                slidesToScroll: 1,
                                asNavFor: '.product-images-main',
                                dots: false,
                                centerMode: true,
                                focusOnSelect: true
                            });
                            /** Слайдер товара **/
                        </script>


                    </div>
                    <div class="right">
                        <div class="product_icons">
                            <div class="product_icons_social">
                                <div class="product_inons_social_popup">
                                    <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                                    <script src="//yastatic.net/share2/share.js"></script>
                                    <div class="ya-share2" data-services="vkontakte,facebook,whatsapp,telegram"></div>
                                </div>
                            </div>

                            <div onclick="productFeaturesWishlist(this)"
                               class="product_icons_wishlist {{ $product->oneProductFeaturesWishlist ? 'active' : '' }}"
                               product_id="{{ $product->id }}"
                               product_url="{{ $product->detailUrlProduct() }}"
                               product_name="{{ $product->name }}"></div>

                            <div onclick="productFeaturesCompare(this)"
                               class="product_icons_compare {{ $product->oneProductFeaturesCompare  ? 'active' : '' }}"
                               product_id="{{ $product->id }}"
                               product_url="{{ $product->detailUrlProduct() }}"
                               product_name="{{ $product->name }}"></div>

                        </div>

                        @php
                            $sku = $product->sku;
                            if(!$sku and $product->parent_id)
                                $sku = $product->parent->sku;
                        @endphp

                        <h1 itemprop="name">{{ $product->name }}</h1>
                        <meta itemprop="mpn" content="{{ $sku }}" />

                        <div class="under_h1">
                            <div class="left_info_product_last_review_rating">
                                <a class="rating_text" href="#reviews">
                                    {{ $product->reviews_count }} Отзыв
                                </a>
                                <div class="rating_stars">
                                    <div class="rating_full" style="width: {{ $product->reviews_rating_avg * 20 }}%"></div>
                                </div>
                            </div>
                            <div style="clear: left;"></div>
                        </div>

                        <span class="stock">
                             @if($product->status_id != 12)
                                <span class="in_stock_icon">
                                    <span>
                                        {!! $product->status->class !!}
                                        {{ $product->status->name }}
                                    </span>
                                </span>
                            @else
                                <span class="out_of_stock_icon">
                                    <span>
                                        {!! $product->status->class !!}
                                        {{ $product->status->name }}
                                   </span>
                                </span>
                            @endif
					    </span>

                        <div class="product_right_sku_container">
                            <div class="product_right_sku">
                                Модель: <span>{{ $sku }}</span>
                            </div>
                        </div>

                        <br/>

                        <div class="left_info_product">
                            <div class="left_info_product_series">

                                @if(count($group_products) > 0)
                                        <select id="select-model-product">
                                            <option value="{{ $product->parent_id ? $product->parent->detailUrlProduct() : '' }}">Выберите вариант</option>
                                            @foreach($group_products as $group_product)
                                                <option value="{{ $group_product->detailUrlProduct() }}" @if($product->id == $group_product->id) selected  @endif>
                                                    {{ $group_product->name }}
                                                    ({{ \App\Tools\Helpers::priceFormat($group_product->getReducedPrice()) }})
                                                    {!! $group_product->status->class !!}
                                                    {{ $group_product->status->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                @endif



                            </div>
                            <div class="product_right_top">
                                <div class="product_manufacturer_logo_right_info">
                                    <a href="{{ $category->catalogUrl() }}">Подробнее<br>
                                        <span>{{ $category->name }}</span>
                                    </a>
                                </div>
                                @if($category->image)
                                    <div class="product_manufacturer_logo">
                                        <a href="/catalog/{{ $category->url }}"
                                           title="{{ $category->name }}"
                                           alt="{{ $category->name }}">
                                            <img src="{{ $category->pathImage(true) }}"
                                                 class="lazyload" data-src="{{ $category->pathImage(true) }}">
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>


                        <div class="some_right">
                            <div class="all_right_block">
                                <div class="all_right_top">

                                    @php $price = $product->getReducedPrice(); @endphp

                                    <div itemprop="offers" itemtype="http://schema.org/Offer" itemscope>
                                        <link itemprop="url" href="{{ $product->detailUrlProduct() }}" />
                                        <meta itemprop="priceCurrency" content="KZT" />
                                        <meta itemprop="itemCondition" content="https://schema.org/UsedCondition" />
                                        <meta itemprop="price" content="{{ $price }}" />
                                        @if($product->stock > 0)
                                            <meta itemprop="availability"  content="https://schema.org/InStock" />
                                            <meta itemprop="itemCondition" content="http://schema.org/NewCondition" />
                                        @else
                                            <meta itemprop="availability" content="https://schema.org/OutOfStock" />
                                        @endif
                                        @php
                                            $specificPrice = $product->specificPrice(function ($query){
                                                                          $query->DateActive();
                                                                     })
                                                                     ->first();
                                        @endphp
                                        @if($specificPrice)
                                            @if($specificPrice->expiration_date)
                                                <meta itemprop="priceValidUntil" content="{{ date('Y-m-d', strtotime($specificPrice->expiration_date)) }}" />
                                            @else
                                                <meta itemprop="priceValidUntil" content="{{date('Y')+1}}-12-31" />
                                            @endif
                                        @else
                                            <meta itemprop="priceValidUntil" content="{{date('Y')+1}}-12-31" />
                                        @endif
                                        <div itemprop="seller" itemtype="http://schema.org/Organization" itemscope>
                                            <meta itemprop="name" content="{{ env('APP_NAME') }}" />
                                        </div>
                                    </div>

                                    <meta itemprop="sku" content="{{ $sku }}" />
                                    <div itemprop="brand" itemtype="http://schema.org/Thing" itemscope>
                                        <meta itemprop="name" content="{{ $category->name }}" />
                                    </div>

                                    @if($product->reviews_rating_avg > 0 and $product->reviews_count > 0)
                                        <div itemprop="aggregateRating" itemtype="http://schema.org/AggregateRating" itemscope>
                                            <meta itemprop="reviewCount" content="{{ $product->reviews_count }}" />
                                            <meta itemprop="ratingValue" content="{{ $product->reviews_rating_avg }}" />
                                        </div>
                                    @endif

                                    @if($product->stock > 0)
                                        <div class="price">
                                            @if($product->specificPrice)
                                                <span class="price-old">
                                                    {{ \App\Tools\Helpers::priceFormat($product->price) }}
                                                </span>
                                            @endif
                                            <span class="price-new">{{ \App\Tools\Helpers::priceFormat($price) }}</span>
                                        </div>
                                    @else
                                        <div class="price_empty">
                                            {{ \App\Tools\Helpers::priceFormat($price) }}
                                            <div class="some_empty_bottom">При поступлении товара,<br>цена может отличаться</div>
                                        </div>
                                    @endif

                                    @if($product->stock > 0)
                                        <div class="oneclick_button" id="oneclick_button_send">
                                            <span>Купить в 1 клик</span>
                                        </div>
                                        <div class="cart">
                                            <a @if($product->inCart) href="/checkout" @endif
                                                product_id="{{ $product->id }}"
                                                onclick="return addToCartInDetail(this)"
                                                id="{{ $product->inCart ? 'button-cart-incart' : 'button-cart' }}">
                                                <span>{{ $product->inCart ? 'В корзине' : 'В корзину' }}</span>
                                            </a>
                                        </div>
                                    @else
                                        <form action="javascript:void(null);" onsubmit="subscribe(this); return false;" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <div class="absent_div">
                                                    <div class="absent_body">
                                                        Оставьте электронную почту, чтобы узнать о поступлении товара
                                                    </div>
                                                    <div class="absent_input">
                                                        <div class="absent_input_button" onclick="$(this).parents('form').submit()"></div>
                                                        <input class="absent_input_input" type="text" name="email" placeholder="Ваша электронная почта">
                                                    </div>
                                                    <div class="absent_email_error">
                                                        Введите корректный e-mail
                                                    </div>
                                                </div>
                                        </form>
                                    @endif

                                </div>
                            </div>

                            <div class="product_specialblock">
                                <a class="product_specialblock_years" href="/guaranty">
                                    <span>
                                        <span>1 год</span><br>
                                        гарантии
                                    </span>
                                </a>
                                <div class="product_delivery_container">
                                    <div><a href="/delivery-payment">Доставка по всему казахстану:</a> от 1000 тг до 3000 тг</div>
                                    <div>
                                        По городам <a href="/delivery-payment">Казахстана</a>,работаем с курьерской компанией "Алем-Тат",
                                        <br/>
                                        срок доставки 3-4 рабочих дня.
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div>
                            <a title="Пишите на WhatsApp"
                               target="_blank"
                               class="whats-app"
                               href="https://api.whatsapp.com/send?phone={{ config('shop.number_phones.0.whats_app') }}&text=Я заинтересован в покупке {{ $product->name }}{{ $product->stock > 0 ? '' : '(Оформить предзаказ)' }}, Подробнее: {{ $product->detailUrlProduct() }}">
                                <img src="/site/images/whatsapp.jpg" width="20"/>
                                Пишите на WhatsApp
                            </a>
                        </div>



                    </div>
                    <div class="cl_b"></div>
                </div>
            </div>

            <div class="product_skladis">
                <div class="skladis_rezerv_adaptive">
                    Желательно по телефону оформить резерв перед посещением магазина.
                </div>
                <div class="product_skladis_body">
                    <div class="product_skladis_header">
                        <div class="product_skladis_shop_left">Адреса магазинов</div>
                        <div class="product_skladis_shop_metro">Расположение</div>
                        <div class="product_skladis_shop_right">Наличие</div>
                    </div>
                    <div class="product_skladis_shop">
                        <div class="product_skladis_shop_left">
                            <a href="/contact">
                                @php
                                    $address = config('shop.address');
                                @endphp
                                {{ $address[0]['addressLocality'] }}, {{ $address[0]['streetAddress'] }}
                            </a>
                        </div>
                        <div class="product_skladis_shop_metro product_skladis_shop_metro_1">
                            <b>г.Алматы</b>
                        </div>

                        @if($product->stock > 0)
                            <div class="product_skladis_shop_right product_skladis_shop_active">
                                <span>Наличие</span>
                            </div>
                        @else
                            <div class="product_skladis_shop_right">
                                <span>Товар отсутствует</span>
                            </div>
                        @endif
                    </div>
                    <span class="skladis_undertext">
                        Желательно по телефону оформить резерв перед посещением магазина.
                    </span>
                    <br/>
                </div>
            </div>

            @include('includes.product_slider', ['products' => $products_interested, 'title' => 'С этим товаром покупают'])
            @include('includes.product_slider', ['products' => $group_products,      'title' => 'Другие варианты'])

            <div class="product_info_bottom" itemprop="description">
                <div class="product_tabs">
                    <div class="product_tabs_htabs">
                        <a tab="tab-descriptions" class="product_tabs_tab_active">
                            Описание
                        </a>
                        <a tab="tab-attributes">
                            Характеристики
                        </a>
                        <a tab="tab-reviews">
                            Отзывы <span>({{ $product->reviews_count }})</span>
                        </a>
                    </div>
                    <div class="product_tabs_content">
                        <div class="active" id="tab-descriptions">
                            {!! $product->description  !!}
                        </div>
                        <div id="tab-attributes">
                            <table class="table">
                                @foreach($product->attributes as $attribute)
                                    @if($attribute->show_product_detail == 1)
                                        <tr>
                                            <td>
                                                @if($attribute->description and $attribute->description != 'null')
                                                    <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{ $attribute->description }}"></i>
                                                @endif
                                                {{ $attribute->pivot->name ? $attribute->pivot->name : $attribute->name }}
                                            </td>
                                            <td>
                                                {{ $attribute->pivot->value }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </table>
                        </div>

                            <div id="tab-reviews">
                                @if(false)
                                    <div class="tab-review-header">
                                        <div class="tab-review-header-left">Отзывы</div>
                                        <div class="tab-review-header-right"><a class="write_review testimonial_write button" href="#"><span>Написать отзыв</span></a></div>
                                    </div>
                                @endif
                                <div class="tab-review-reviews">
                                    <div type="lis-comments"
                                         lis-widget="reviews"
                                         data-id="{{    $product->parent_id ? $product->parent_id    : $product->id }}"
                                         data-title="{{ $product->parent_id ? $product->parent->name : $product->name }}">
                                    </div>
                                    @if(false)
                                        @if(count($product->reviews) == 0)
                                            <br/>
                                            <p>Нет отзывы</p>
                                        @else
                                            @foreach($product->reviews as $review)
                                                    <div class="one-review" itemprop="review" itemtype="http://schema.org/Review" itemscope>

                                                        <div itemprop="reviewRating" itemtype="http://schema.org/Rating" itemscope>
                                                            <meta itemprop="ratingValue" content="{{ $review->rating }}" />
                                                            <meta itemprop="bestRating"  content="5" />
                                                            <meta itemprop="worstRating" content="1" />
                                                        </div>

                                                        <div class="one-review-left">
                                                            <div class="one-review-left-author" itemprop="author" itemtype="http://schema.org/Person" itemscope>
                                                               <span itemprop="name">{{ $review->name }}</span>
                                                            </div>
                                                            <div class="one-review-left-date" itemprop="datePublished" content="{{ date('Y-m-d', strtotime($review->created_at)) }}">
                                                                {{ \App\Tools\Helpers::ruDateFormat($review->created_at) }}
                                                            </div>
                                                            <div class="rating_stars">
                                                                <div class="rating_full" style="width: {{ $review->rating * 20 }}%"></div>
                                                            </div>
                                                        </div>
                                                        <div class="one-review-right" itemprop="reviewBody">
                                                            <div class="one-review-right-text-plus">
                                                                <span class="review-head">Достоинства</span>
                                                                <span class="review-text">
                                                                     {{ $review->plus }}
                                                                </span>
                                                            </div>
                                                            <div class="one-review-right-text-minus">
                                                                <span class="review-head">Недостатки</span>
                                                                <span class="review-text">
                                                                     {{ $review->minus  }}
                                                                </span>
                                                            </div>
                                                            <div class="one-review-right-text">
                                                                <span class="review-head">Комментарий</span>
                                                                <span class="review-text">
                                                                    {{ $review->comment }}
                                                                </span>
                                                            </div>
                                                            <div class="as_yandex_review" id="as_yandex_review_{{ $review->id }}">
                                                                <span class="as_yandex_review_text">Вам понравился отзыв?</span>
                                                                <div class="as_yandex_review_plus
                                                                                @if(isset($review->isLike->like))
                                                                                    @if($review->isLike->like == 1) as_yandex_review_plus_active @endif
                                                                                @endif" review_id="{{ $review->id }}">
                                                                    <span class="image"></span>
                                                                    <span class="as_yandex_review_number">
                                                                        {{ $review->likes_count ?? 0 }}
                                                                    </span>
                                                                </div>
                                                                <div class="as_yandex_review_minus
                                                                                @if(isset($review->isLike->like))
                                                                                    @if($review->isLike->like == 0) as_yandex_review_minus_active @endif
                                                                                @endif" review_id="{{ $review->id }}">
                                                                    <span class="image"></span>
                                                                    <span class="as_yandex_review_number">
                                                                        {{ $review->dis_likes_count ?? 0 }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            @endforeach
                                        @endif
                                    @endif
                                </div>
                            </div>

                        <div class="product_orange">Пожалуйста, если вы увидели, что в описании товара есть ошибка, например, фактическая или просто опечатка, то <a href="#">дайте нам знать</a>. Мы быстро исправим.</div>
                    </div>
                </div>
            </div>

        </div>

    </div>






    <div id="one-click-order" style="display: none;">
        <div class="oneclick_popup">
            <div class="oneclick_popup_line"></div>
            <div class="oneclick_popup_header">Быстрый заказ
                <div class="oneclick_popup_close"></div>
            </div>
            <form action="javascript:void(null);" onsubmit="oneClickOrder(this); return false;" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="oneclick_show_info">
                    <div class="oneclick_show_input">
                        <div class="oneclick_show_text">
                            Имя:
                        </div>
                        <input @auth value="{{ Auth::user()->name }}" @endauth type="text" name="name" placeholder="Имя"/>
                    </div>
                    <div class="oneclick_show_input">
                        <div class="oneclick_show_text">
                            E-mail:
                        </div>
                        <input @auth value="{{ Auth::user()->email }}" @endauth type="email" name="email" placeholder="E-mail"/>
                    </div>
                    <div class="oneclick_show_input">
                        <div class="oneclick_show_text">
                            Введите номер телефона:
                        </div>
                        <input @auth value="{{ Auth::user()->phone }}" @endauth type="text" name="phone" placeholder="+7 (___) ___-__-__" class="phone-mask"/>
                    </div>
                </div>
                <div class="oneclick_button">
                    <a href="#" onclick="$(this).parents('form').submit()" class="buy_one_click button">
                        <span>
                            <img style="display: none" src="/site/images/ajax-loader.gif"/>
                            Заказать
                        </span>
                    </a>
                </div>
            </form>
        </div>
    </div>


    @if(false)
    <div id="write-question-popup" style="display:none;">
        <div class="question_popup">
            <form action="javascript:void(null);" onsubmit="writeQuestion(this); return false;" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="question_popup_line"></div>
                <div class="question_popup_header">Новый вопрос
                    <div class="question_popup_close"></div>
                </div>
                <div class="question_popup_inputs">
                    <div class="question_popup_input_left">
                        <div class="question_popup_input_header">Ваше имя <span class="required">*</span>:</div>
                        <div class="question_popup_input_input">
                            <input name="name" placeholder="Введите имя" value="" type="text">
                        </div>
                    </div>
                    <div class="question_popup_input_right">
                        <div class="question_popup_input_header">Ваш e-mail <span class="required">*</span>:</div>
                        <div class="question_popup_input_input">
                            <input name="email" placeholder="Введите e-mail" value="" type="text">
                        </div>
                    </div>
                </div>
                <div class="question_popup_text">
                    <div class="question_popup_text_header">Ваш вопрос <span class="required">*</span>:</div>
                    <div class="question_popup_text_textarea">
                        <textarea name="question" placeholder="Задайте вопрос нашим специалистам" style="height: 90px;"></textarea>
                    </div>
                </div>
                <div class="question_popup_button">
                    <a onclick="$(this).parents('form').submit()" class="button qa_send" id="button-question">
                        <span>Задать вопрос</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div id="write-review-popup" style="display: none;">
        <div class="review_popup">
            <form action="javascript:void(null);" onsubmit="writeReview(this); return false;" method="post" enctype="multipart/form-data">
                @csrf
                <div class="review_popup_line"></div>
                <div class="review_popup_header">
                    Написать отзыв
                    <div class="review_popup_close"></div>
                </div>
                <div class="review_popup_rating">
                    <div class="review_popup_rating_header">Оценка</div>
                    <div class="review_popup_rating_stats">
                        <div id="raiting_star">
                            <div id="raiting">
                                <div id="raiting_blank"></div>
                                <div id="raiting_hover" style="width: 120px; display: none;"></div>
                                <div id="raiting_votes" style="width: 0px; display: block;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="rating" value="0">
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div class="review_popup_plus">
                    <div class="review_popup_plus_header">Достоинства:</div>
                    <div class="review_popup_plus_textarea">
                        <textarea name="plus" placeholder="Что вам понравилось"></textarea>
                    </div>
                </div>
                <div class="review_popup_minus">
                    <div class="review_popup_minus_header">Недостатки:</div>
                    <div class="review_popup_minus_textarea">
                        <textarea name="minus" placeholder="Опишите недостатки"></textarea>
                    </div>
                </div>
                <div class="review_popup_inputs">
                    <div class="review_popup_input_left">
                        <div class="review_popup_input_header">Ваше имя <span class="required">*</span>:</div>
                        <div class="review_popup_input_input">
                            <input name="name" placeholder="Введите имя" value="" type="text">
                        </div>
                    </div>
                    <div class="review_popup_input_right">
                        <div class="review_popup_input_header">Ваш e-mail:</div>
                        <div class="review_popup_input_input">
                            <input required name="email" placeholder="Введите e-mail" value="" type="text">
                        </div>
                    </div>
                </div>
                <div class="review_popup_text">
                    <div class="review_popup_text_header">Комментарий <span class="required">*</span>:</div>
                    <div class="review_popup_text_textarea">
                        <textarea required name="comment" placeholder="Введите комментарий" style="height: 90px;"></textarea>
                    </div>
                </div>
                <div class="review_popup_button">
                    <a onclick="$(this).parents('form').submit()" class="button testimonial_send" id="button-review">
                        <span>Отправить отзыв</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
    @endif

@endsection
