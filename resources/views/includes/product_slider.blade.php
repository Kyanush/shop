@if(isset($products))
@if(count($products) > 0)
        <div class="rr-widget cartRelated rr-active">
            <header class="widgettitle">{{ $title }}</header>
            <ul class="items">

                @foreach($products as $product)
                    <li class="item">
                        <div class="block">
                            <div class="rr-header">
                                <div class="rr-labels">

                                    @if($product->specificPrice)
                                        <div class="rr-discount">
                                            {{ $product->getDiscountTypeinfo() }}
                                        </div>
                                    @endif

                                    @foreach($product->attributes as $attribute)
                                        @if($attribute->id == 49 and $attribute->pivot->value)
                                            <div class="rr-{{ str_slug($attribute->pivot->value)  }}">{{ $attribute->pivot->value  }}</div>

                                            <!--
                                            <div class="rr-hit">Хит</div>
                                            <div class="rr-new">New!</div>
                                            <div class="rr-global">dsd</div>
                                            <div class="rr-eac">dsd</div>-->
                                        @endif
                                    @endforeach

                                </div>

                                <div class="rr-icons">

                                        <a onclick="productFeaturesWishlist(this)"
                                           class="product_features_wishlist {{ $product->oneProductFeaturesWishlist ? 'active' : '' }}"
                                           product_id="{{ $product->id }}"
                                           product_url="{{ $product->detailUrlProduct() }}"
                                           product_name="{{ $product->name }}"
                                           tabindex="0"></a>

                                        <span onclick="productFeaturesCompare(this)"
                                              class="product_features_compare {{ $product->oneProductFeaturesCompare  ? 'active' : '' }}"
                                              product_id="{{ $product->id }}"
                                              product_url="{{ $product->detailUrlProduct() }}"
                                              product_name="{{ $product->name }}"></span>

                                </div>
                            </div>
                            <a class="item-info" href="{{ $product->detailUrlProduct() }}">
                                <div class="item-image">
                                    <img class="lazy"
                                         title="{{ $product->name }}"
                                         alt="{{ $product->name }}"
                                         data-original="{{ $product->pathPhoto(true) }}"/>
                                </div>
                                <div class="item-title">{{ $product->name }}</div>
                            </a>
                            <div class="rating">
                                <div class="rating_left">
                                    <a class="rating_stars" href="{{ $product->detailUrlProduct() }}" tabindex="-1">
                                        <div class="rating_full stars_{{ $product->avgRating[0]->avg_rating ?? 0 }}"></div>
                                    </a>
                                </div>
                                <div class="rating_right">
                                    <a class="rating_reviews" href="{{ $product->detailUrlProduct() }}/reviews">
                                        {{ $product->reviews_count }}
                                    </a>
                                </div>
                            </div>
                            <div class="item-price-and-buy">
                                <div class="item-block-price">

                                    @if($product->specificPrice)
                                        <div class="item-old-price">
                                            <span class="item-old-price-value">{{ \App\Tools\Helpers::priceFormat($product->price) }}</span>
                                            <!--<span class="item-price-currency"></span>-->
                                        </div>
                                    @endif

                                    <div class="item-price">
                                        <span class="item-price-value">
                                            {{ \App\Tools\Helpers::priceFormat($product->getReducedPrice()) }}
                                        </span>
                                        <!-- <span class="item-price-currency"></span>-->
                                    </div>

                                </div>
                                <div class="item-actions">

                                    @if($product->stock > 0)
                                        <a @if($product->inCart) href="/checkout" @endif
                                            onclick="addToCartInList(this)" class="item-actions-buy {{ $product->inCart ? 'added' : '' }}" product_id="{{ $product->id }}">
                                            <div class="add_to_cart_help">Товар в корзине</div>
                                        </a>
                                    @else
                                        <a class="item-actions-buy no-stock">
                                        </a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
@endif
@endif