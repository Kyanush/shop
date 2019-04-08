<div class="g-mb-gtn">
    <div class="item container g-pa0 g-bb0">


        <div class="item__images">
            <div class="swiper-container" id="product-slider">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="item__image-wrapper">
                            <img alt="{{ $product->name }}" title="{{ $product->name }}" class="item__image" src="{{ $product->pathPhoto(true) }}"/>
                        </div>
                    </div>

                    @foreach($product->images as $image)
                        <div class="swiper-slide">
                            <div class="item__image-wrapper">
                                <img alt="{{ $product->name }}" title="{{ $product->name }}" class="item__image" src="{{ $image->imagePath(true) }}"/>
                            </div>
                        </div>
                    @endforeach

                    @if(!empty($product->attributes[200]->pivot->value))
                        <div class="swiper-slide">
                            <div class="item__image-wrapper _video play-icon">
                                <img class="item__image" src="https://i.ytimg.com/vi/{{ $product->attributes[200]->pivot->value }}/mqdefault.jpg">
                            </div>
                        </div>
                    @endif

                </div>

                @if(count($product->images) > 0)
                    <div class="swiper-pagination"></div>
                @endif
            </div>


            <div class="item__control">
                @if(!empty($product->attributes[200]->pivot->value))
                    <div class="item__control-button _video _show">
                        <i class="icon icon_video"></i>
                        <span>Видео</span>
                    </div>
                @else
                    <div class="item__control-button"></div>
                @endif
                <div class="item__control-button _zoom _show">
                    <span>Увеличить</span>
                    <i class="icon icon_zoom"></i>
                </div>
            </div>

            <div class="item__badges _left">
                @foreach($product->attributes as $attribute)
                    @if($attribute->id == 49 and $attribute->pivot->value)
                        @if($attribute->pivot->value == 'Хит')
                            <div class="hit"><img src="/site/images/sticker_hit.png"> Хит</div>
                        @endif
                        @if($attribute->pivot->value == 'New!')
                            <div class="new">New!</div>
                        @endif
                    @endif
                @endforeach
            </div>

            <div class="item__badges _right">
                <div onclick="productFeaturesWishlist(this)"
                     class="product_features_wishlist {{ $product->oneProductFeaturesWishlist ? 'active' : '' }}"
                     product_id="{{ $product->id }}"
                     product_url="{{ $product->detailUrlProduct() }}"
                     product_name="{{ $product->name }}"></div>
                <div onclick="productFeaturesCompare(this)"
                     class="product_features_compare {{ $product->oneProductFeaturesCompare  ? 'active' : '' }}"
                     product_id="{{ $product->id }}"
                     product_url="{{ $product->detailUrlProduct() }}"
                     product_name="{{ $product->name }}"></div>
            </div>

        </div>

        <div class="item__info container">
            <h1 class="item__name">
                {{ $product->name }}
            </h1>
            <a class="item__rating">
                <span class="rating _{{ ($product->avgRating->avg_rating ?? 0) * 2}}"></span>
                <span class="rating-count">(<span> {{ $product->reviews_count }}</span>&nbsp;отзывов)</span>
            </a>
            <div class="item__sku">Код товара:&nbsp;{{ $product->sku }}</div>
        </div>

        <div class="item__info container text-center">
            <?php $user = Auth::user();?>
            <button
                    type="button"
                    class="button _white"
                    onclick="buyIn1Click({{ $product->id }}, '{{ $user->name ?? '' }}', '{{ $user->email ?? '' }}', '{{ $user->phone ?? '' }}')">
                Купить в 1 клик
            </button>
        </div>

        <div class="item__prices">
            <div class="item__debet">
                <span class="item__prices-price">
                    @if($product->specificPrice)
                        <span class="price-old">
                             {{ \App\Tools\Helpers::priceFormat($product->price) }}
                        </span>
                        &nbsp;
                    @endif
                    {{ \App\Tools\Helpers::priceFormat($product->getReducedPrice()) }}
                </span>
            </div>
            <!--
            <div class="item__instalment">
                <span class="item__prices-title">В кредит</span>
                <span class="item__prices-price">19 654 ₸</span>
                <span class="item__add-info">х24 мес</span>
            </div>-->
        </div>




    </div>

    <h2 class="container-title">Поховые товары</h2>
    <div class="mount-sellers-offers _short-list" id="sellers">
        <div class="sellers-offers _short-list">

            <div class="_sellers-offers">
                <div class="container loan-selector g-bb-fat">
                    <div class="loan-selector__text-before">Цвета</div>
                    <div class="loan-selector__els g-fl-r ">
                        <div class="loan-selector__els-row">

                            @foreach($group_products as $group_product)
                                @foreach($group_product->attributes as $attribute)
                                    @if($attribute->id == 50 and $attribute->pivot->value)
                                        <a title="{{ $attribute->pivot->value . '-' . $group_product->name }}" class="loan-selector__el" href="{{ $group_product->detailUrlProduct() }}">
                                            <div style="background: {{ \App\Tools\Helpers::colorProduct($attribute->pivot->value) }}"></div>
                                        </a>
                                    @endif
                                @endforeach
                            @endforeach

                            @foreach($product->attributes as $attribute)
                                @if($attribute->id == 50 and $attribute->pivot->value)
                                        <a title="{{ $attribute->pivot->value . '-' . $product->name }}" class="loan-selector__el _active">
                                            <div style="background: {{ \App\Tools\Helpers::colorProduct($attribute->pivot->value) }}"></div>
                                        </a>
                                @endif
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>





            <h2 class="container-title">Характеристики</h2>
            <div class="short-specifications container">
                <ul class="short-specifications__list">
                    @foreach($product->attributes as $k => $attribute)

                        @if(empty($attribute->attribute_group_id))
                            @continue
                        @endif

                        <li class="short-specifications__list-el">{{ $attribute->name }}: {{ $attribute->pivot->value }};</li>
                        @if($k == 5)
                            @php break; @endphp
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="container g-pa0 g-bb-fat">
                <a href="{{ $product->detailUrlProduct() }}/attributes" class="link-more _link-specifications">Подробнее</a>
            </div>









            <h2 class="container-title">Отзывы</h2>
            <div class="reviews__rating container ">
                <div class="reviews__rating-heading">Рейтинг товара</div>
                <a href="{{ $product->detailUrlProduct() }}/reviews" class="reviews__rating-link">
                    <span class="rating _big _{{ ($product->avgRating->avg_rating ?? 0) * 2}}"></span>
                    <span class="rating-count g-fl-r">
                        <span>{{ $product->reviews_count }}</span>&nbsp;
                        отзывов
                    </span>
                </a>
            </div>

            @if(count($product->reviews) == 0)
                <p>Нет отзывы</p>
            @else
                @foreach($product->reviews as $review)
                    @include('mobile.product.review_item', ['review' => $review, 'like_show' => false, 'review_text_class' => '_short'])
                @endforeach
            @endif

            <div class="container g-pa0 g-bb-fat">
                <a href="{{ $product->detailUrlProduct() }}/reviews" class="link-more _link-reviews">
                    Еще {{ $product->reviews_count }}&nbsp;отзывов
                </a>
            </div>


            <h2 class="container-title">Описание</h2>
            <div class="container">
                <div class="short-description">
                    {!! strip_tags(\App\Tools\Helpers::closeTags(\App\Tools\Helpers::limitWords($product->description, 30))) !!}
                </div>
            </div>
            <div class="container g-pa0 g-bb-fat">
                <a href="{{ $product->detailUrlProduct() }}/descriptions" class="link-more _link-description">
                    Подробнее
                </a>
            </div>

            @include('mobile.includes.product_slider', ['products' => $products_interested, 'title' => 'С этим товаром покупаю', 'url' => ''])
            @include('mobile.includes.product_slider', ['products' => $youWatchedProducts,  'title' => 'Вы смотрели', 'url' => ''])

            <button type="button" class="button _big-fixed button-sellers" onclick="_addToCart({{ $product->id }})">
                Оформить заказ
            </button>

        </div>
    </div>
</div>