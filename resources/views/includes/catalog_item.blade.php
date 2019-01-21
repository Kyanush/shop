<div>
    <div class="product_bg"></div>
    <div class="product_inner">
        <div class="product_features_top">

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

            <div class="product_features_buttons">

                <a onclick="productFeaturesWishlist(this)"
                   class="product_features_wishlist {{ $product->oneProductFeaturesWishlist ? 'active' : '' }}"
                   product_id="{{ $product->id }}"
                   product_url="{{ $product->detailUrlProduct() }}"
                   product_name="{{ $product->name }}"></a>

                <a onclick="productFeaturesCompare(this)"
                   class="product_features_compare {{ $product->oneProductFeaturesCompare  ? 'active' : '' }}"
                   product_id="{{ $product->id }}"
                   product_url="{{ $product->detailUrlProduct() }}"
                   product_name="{{ $product->name }}"></a>

            </div>
        </div>

        <div class="image">
            <a href="{{ $product->detailUrlProduct() }}">
                <img class="lazyload"
                     src="{{ $product->pathPhoto(true) }}"
                     title="{{ $product->name }}"
                     alt="{{ $product->name }}">
            </a>
        </div>

        <div class="name">
            <a href="{{ $product->detailUrlProduct() }}" itemprop="name">
                {{ $product->name }}
            </a>
        </div>
        <div class="description">
            <ul>
                <?php $row = 0; ?>
                @foreach($product->attributes as $key => $attribute)
                    @if($attribute->attribute_group_id > 0 and $attribute->pivot->value)
                        <?php $row++;
                            if($row == 5) break;
                        ?>
                        <li>
                            <div class="attr_left">
                                <span>{{ $attribute->name }}:</span>
                            </div>
                            <div class="attr_right">
                                <span>{{ $attribute->pivot->value }}</span>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="rating">
            <div class="rating_left">
                <a class="rating_stars" href="{{ $product->detailUrlProduct() }}#reviews">
                    <div class="rating_full" style="width: {{ intval($product->avgRating->avg_rating ?? 0) * 20 }}%"></div>
                </a>
            </div>
            <div class="rating_right">
                <a class="rating_reviews" href="{{ $product->detailUrlProduct() }}/reviews">
                    {{ $product->reviews_count }}
                </a>
            </div>
        </div>
        <div class="product_bottom">
            <div class="price">
                @if($product->specificPrice)
                    <span itemprop="price" class="price-old">
                        {{ \App\Tools\Helpers::priceFormat($product->price) }}
                    </span>
                @endif
                <span class="price-new">
                     {{ \App\Tools\Helpers::priceFormat($product->getReducedPrice()) }}
                </span>
            </div>
            <div class="stock">
                @if($product->stock > 0)
                    <span class="in_stock_icon">
                        В наличии
                        <span></span>
                    </span>
                @else
                    Нет в наличии
                @endif
            </div>
            <div class="cart">
                @if($product->stock > 0)
                    <a @if($product->inCart) href="/checkout" @endif onclick="addToCartInList(this)" product_id="{{ $product->id }}"
                       class="button {{ $product->inCart ? 'added' : '' }}">
                        <span></span>
                        <div class="add_to_cart_help">Товар в корзине</div>
                    </a>
                @else
                    <a onclick="return false;" class="button button_unavailable"><span></span></a>
                @endif
            </div>
            <div class="cl_b"></div>
        </div>
    </div>
</div>