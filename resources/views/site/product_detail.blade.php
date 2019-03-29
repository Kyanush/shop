@extends('layouts.site')

@section('title',    	 $product->name)
@section('description', $product->seo_description ? $product->seo_description : $product->name)
@section('keywords',    $product->seo_keywords    ? $product->seo_keywords    : $product->name)

@section('og_title',    	 $product->name)
@section('og_description',  $product->seo_description ? $product->seo_description : strip_tags(\App\Tools\Helpers::closeTags(\App\Tools\Helpers::limitWords($product->description, 100))))
@section('og_image',    	 env('APP_URL') . $product->pathPhoto(true))

@section('content')





    <div class="container" style="position:static;">

        <?php $breadcrumb = [
            [
                'title' => 'Главная',
                'link'  => '/'
            ],
            [
                'title' => $category->name,
                'link'  => '/catalog/' . $category->url
            ],
            [
                'title' => $product->name,
                'link'  => ''
            ]
        ];?>
        @include('includes.breadcrumb', ['breadcrumb' => $breadcrumb])

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
                                <div class="item" style="background-image: url('{{ $product->pathPhoto(true) }}')"
                                     title="{{ $product->name }}"
                                     alt="{{ $product->name }}">
                                </div>
                                @foreach($product->images as $image)
                                    <div class="item" style="background-image: url('{{ $image->imagePath(true) }}')"
                                         title="{{ $product->name }}"
                                         alt="{{ $product->name }}">
                                    </div>
                                @endforeach
                            </div>

                            @if(count($product->images) > 0)
                                <div class="product-images-nav">
                                    <div class="item">
                                        <img src="{{ $product->pathPhoto(true) }}"
                                             title="{{ $product->name }}"
                                             alt="{{ $product->name }}">
                                    </div>
                                    @foreach($product->images as $image)
                                        <div class="item">
                                            <img src="{{ $image->imagePath(true) }}"
                                                 title="{{ $product->name }}"
                                                 alt="{{ $product->name }}">
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                        </div>


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

                        <h2>{{ $product->name }}</h2>

                        <div class="under_h1">
                            <div class="left_info_product_last_review_rating" itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
                                <a class="rating_text" href="#reviews">
                                    {{ $product->reviews_count }} Отзыв
                                </a>
                                <div class="rating_stars">
                                    <div class="rating_full" style="width: {{ intval($product->avgRating->avg_rating ?? 0) * 20 }}%"></div>
                                </div>
                            </div>
                            <div style="clear: left;"></div>
                        </div>



                        <div class="pseudo_h1">
                            {{ $product->name }}
                        </div>

                        <span class="stock">
                             @if($product->stock > 0)
                                <span class="in_stock_icon">
                                    <span>В наличии</span>
                                </span>
                            @else
                                <span class="out_of_stock_icon">
                                    <span>Товар отсутствует</span>
                                </span>
                            @endif
					    </span>

                        <div class="product_right_sku_container">
                            <div class="product_right_sku">Артикул: <span>{{ $product->sku }}</span>
                            </div>
                        </div>

                        <div class="left_info_product">
                            <div class="left_info_product_series">

                                @foreach($product->attributes as $attribute)
                                    @if($attribute->id == 50 and $attribute->pivot->value)
                                        <div class="left_info_product_series_header">Цвет: <span>{{ $attribute->pivot->value }}</span></div>
                                    @endif
                                @endforeach

                                <div class="left_info_product_series_colors">
                                    @foreach($group_products as $group_product)
                                        @foreach($group_product->attributes as $attribute)
                                            @if($attribute->id == 50 and $attribute->pivot->value)
                                                <a title="{{ $attribute->pivot->value }} - {{ $group_product->name }}" class="left_info_product_series_color left_info_product_series_color_active" href="{{ $group_product->detailUrlProduct() }}">
                                                    <div class="left_info_product_series_color_middle"
                                                         style="background: {{ \App\Tools\Helpers::colorProduct($attribute->pivot->value) }}">
                                                    </div>
                                                </a>
                                            @endif
                                        @endforeach
                                    @endforeach
                                    <span class="cl_l"></span>
                                </div>
                            </div>
                            <div class="product_right_top">
                                <div class="product_manufacturer_logo_right_info">
                                    <a href="/catalog/{{ $category->url }}">Подробнее<br>
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
                                <div class="all_right_top" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">

                                    @if($product->stock > 0)
                                        <div class="price">
                                            @if($product->specificPrice)
                                                <span class="price-old">
                                                    {{ \App\Tools\Helpers::priceFormat($product->price) }}
                                                </span>
                                            @endif
                                            <span class="price-new">
                                                {{ \App\Tools\Helpers::priceFormat($product->getReducedPrice()) }}
                                            </span>
                                        </div>
                                    @else
                                        <div class="price_empty">
                                            {{ \App\Tools\Helpers::priceFormat($product->getReducedPrice()) }}
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
                                </div>
                            </div>

                            <div class="go_to_description">
                                <a>Перейти к описанию товара</a>
                            </div>

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
                                г. Алматы, ул. Жибек жолы 115, оф. 113 (Рядом Аэровокзала)
                            </a>
                        </div>
                        <div class="product_skladis_shop_metro product_skladis_shop_metro_1">г.Алматы</div>

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


            @if(count($products_interested) > 0)
                <span class="you-may-be-interested">
                    @include('includes.product_slider', ['products' => $products_interested, 'title' => 'С этим товаром покупают'])
                </span>
            @endif



            <?php $questionsAnswers = \App\Tools\Helpers::createTree($product->questionsAnswers);?>

            @if($product_tab)
                <script>
                    $(document).ready(function() {
                        $('html, body').animate({scrollTop: $('#tab-{{ $product_tab }}').offset().top - 70}, 1100);
                    });
                </script>
            @endif

            <div class="product_info_bottom">
                <div class="product_tabs">
                    <div class="product_tabs_htabs">

                        <a href="{{ $product->detailUrlProduct() }}/descriptions"
                           tab="tab-descriptions"
                           @if($product_tab == 'descriptions' or !$product_tab)
                                class="product_tabs_tab_active"
                           @endif>Описание</a>

                        <a href="{{ $product->detailUrlProduct() }}/attributes"
                           tab="tab-attributes"
                           @if($product_tab == 'attributes')
                                class="product_tabs_tab_active"
                           @endif>Характеристики</a>

                        <a href="{{ $product->detailUrlProduct() }}/reviews"
                           tab="tab-reviews"
                           @if($product_tab == 'reviews')
                                class="product_tabs_tab_active"
                           @endif>Отзывы <span>( {{ $product->reviews_count }})</span></a>

                        <a href="{{ $product->detailUrlProduct() }}/questions"
                           tab="tab-questions"
                           @if($product_tab == 'questions')
                                class="product_tabs_tab_active"
                           @endif>Вопрос-ответ <span>({{ count($questionsAnswers) }})</span></a>

                    </div>
                    <div class="product_tabs_content">
                        <div @if($product_tab == 'descriptions' or !$product_tab) class="active"  @endif id="tab-descriptions">
                            {!! $product->description  !!}
                        </div>
                        <div @if($product_tab == 'attributes')   class="active"  @endif id="tab-attributes">
                            <div class="tab_attribute_all">
                                <div class="tab_attribute_left tab_attribute_left_fixed1">

                                    <div class="tab_attribute_left_div">


                                        <?php $attributes = [];?>

                                        @foreach($product->attributes as $attribute)
                                            @if(empty($attribute->attribute_group_id))
                                                @continue
                                            @endif
                                            <?php $attributes[$attribute->attribute_group_id][] = $attribute;?>
                                        @endforeach


                                        <?php $active = true; ?>
                                        @foreach(App\Models\AttributeGroup::OrderBy('sort')->get() as $attributeGroup)
                                            @if(!isset($attributes[$attributeGroup->id]))
                                                @continue
                                            @endif
                                            <div class="tab_attribute_group_left @if($active) tab_attribute_group_left_active @endif" tab_attribute_id="{{ $attributeGroup->id }}">
                                                {{ $attributeGroup->name }}
                                            </div>
                                            <?php $active = false;?>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab_attribute_right">

                                    @foreach(App\Models\AttributeGroup::OrderBy('sort')->get() as $attributeGroup)
                                        @if(!isset($attributes[$attributeGroup->id]))
                                            @continue
                                        @endif
                                        <div class="tab_attribute_group_right_main">
                                            <div class="tab_attribute_group_right_top" tab_attribute_content="{{ $attributeGroup->id }}">{{ $attributeGroup->name }}</div>
                                            <div class="tab_attribute_group_right_attributes">
                                                    @foreach($attributes[$attributeGroup->id] as $attribute)
                                                        <div class="tab_attribute_group_right_attributes_obolochka">
                                                            <div class="tab_attribute_group_right_attributes_left">
                                                                <span>{{ $attribute->name }}</span>
                                                            </div>
                                                            <div class="tab_attribute_group_right_attributes_right">
                                                                <span>{{ $attribute->pivot->value }}</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="tab_attribute_right_addition">
                                        Технические характеристики и комплектации товара могут<br>
                                        быть изменены без уведомления со стороны производителя
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div @if($product_tab == 'reviews')      class="active"  @endif id="tab-reviews">
                            <div class="tab-review-header">
                                <div class="tab-review-header-left">Отзывы</div>
                                <div class="tab-review-header-right"><a class="write_review testimonial_write button" href="#"><span>Написать отзыв</span></a></div>
                            </div>
                            <div class="tab-review-reviews">
                                @if(count($product->reviews) == 0)
                                    <br/>
                                    <p>Нет отзывы</p>
                                @else
                                    @foreach($product->reviews as $review)
                                            <div class="one-review" itemprop="review" itemscope="" itemtype="http://schema.org/Review">
                                                <div class="one-review-left">
                                                    <div class="one-review-left-author" itemprop="author">
                                                        {{ $review->name }}
                                                    </div>
                                                    <div class="one-review-left-date" content="2017-08-09" itemprop="datePublished">
                                                        {{ \App\Tools\Helpers::ruDateFormat($review->created_at) }}
                                                    </div>
                                                    <div class="rating_stars" itemprop="reviewRating" itemscope="" itemtype="http://schema.org/Rating">
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

                            </div>
                        </div>
                        <div @if($product_tab == 'questions')   class="active"  @endif id="tab-questions">
                            <div class="tab-questions-header">
                                <div class="tab-questions-header-left">Вопрос-ответ</div>
                                <div class="tab-questions-header-right">
                                    <a class="write_question qa_write button" href="#">
                                        <span>Задать вопрос</span>
                                    </a>
                                </div>
                            </div>

                            @if(count($questionsAnswers) == 0)
                                <div class="reviews_clear">Еще никто не задал вопрос по данному товару.</div>
                            @else
                                <div class="tab-questions-body">
                                    @foreach($questionsAnswers as $question_answer)
                                        <div class="one-question">
                                            <div class="tab-questions-body-left">
                                                <div class="tab-questions-body-left-author">
                                                    {{ $question_answer->name }}
                                                </div>
                                                <time>
                                                    {{ \App\Tools\Helpers::ruDateFormat($question_answer->created_at) }}
                                                </time>
                                            </div>
                                                <div class="tab-questions-body-right">
                                                    <div class="text">
                                                        {{ $question_answer->question }}
                                                    </div>
                                                        <div class="text_otvet">
                                                            <div class="text_otvet_left">Ответ компании
                                                                <div class="kitmall_otvet"></div>
                                                            </div>
                                                            <div class="text_otvet_right">
                                                                {{ $question_answer->answer }}
                                                            </div>
                                                        </div>
                                                </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                        </div>

                        <div class="product_orange">Пожалуйста, если вы увидели, что в описании товара есть ошибка, например, фактическая или просто опечатка, то <a href="#">дайте нам знать</a>. Мы быстро исправим.</div>

                    </div>


                </div>
            </div>




            <br/>
            <br/>
            @include('includes.product_slider', ['products' => $youWatchedProducts, 'title' => 'Вы смотрели'])

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
                        <input @auth disabled value="{{ Auth::user()->name }}" @endauth type="text" name="name" placeholder="Имя"/>
                    </div>
                    <div class="oneclick_show_input">
                        <div class="oneclick_show_text">
                            E-mail:
                        </div>
                        <input @auth disabled value="{{ Auth::user()->email }}" @endauth type="email" name="email" placeholder="E-mail"/>
                    </div>
                    <div class="oneclick_show_input">
                        <div class="oneclick_show_text">
                            Введите номер телефона:
                        </div>
                        <input @auth disabled value="{{ Auth::user()->phone }}" @endauth type="text" name="phone" placeholder="+7 (___) ___-__-__" class="phone-mask"/>
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


@endsection