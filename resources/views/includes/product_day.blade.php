<?php

$productDay =  \App\Models\Product::productInfoWith()
                ->filtersAttributes(['product_day' => 'da'])
                ->limit(1)
                ->inRandomOrder()
                ->first();
?>

@if($productDay)
<div class="product-of-day">

    @if($productDay->specificPrice)
        <div class="product_of_day">
            <span class="economy_text">Экономия</span>
            <span class="economy_price">
                 {{ $productDay->getDiscountTypeinfo() }}
            </span>
        </div>
    @endif

    <div class="day_title">Товар дня</div>
    <div class="image">
        <a href="{{ $productDay->detailUrlProduct() }}">
            <img src="{{ $productDay->pathPhoto(true) }}"
                 title=" {{ $productDay->name }}"
                 alt=" {{ $productDay->name }}"></a>
    </div>
    <div class="category_name">Гаджеты</div>
    <div class="name">
        <a href="{{ $productDay->detailUrlProduct() }}">
            {{ $productDay->name }}
        </a>
    </div>
    <div class="description"></div>
    <div class="rating">
        <div class="rating_left">

            <a class="rating_stars" href="{{ $productDay->detailUrlProduct() }}#reviews" tabindex="-1">
                <div class="rating_full stars_{{ $productDay->avgRating->avg_rating ?? 0 }}"></div>
            </a>

        </div>
        <div class="rating_right">
            <a class="rating_reviews" href="{{ $productDay->detailUrlProduct() }}/reviews">
                {{ $productDay->reviews_count }}
            </a>
        </div>
    </div>
    <div class="product_bottom">
        <div class="price">
            @if($productDay->specificPrice)
                <span class="price-old">{{ \App\Tools\Helpers::priceFormat($productDay->price) }}</span>
            @endif
            <span class="price-new">
                 {{ \App\Tools\Helpers::priceFormat($productDay->getReducedPrice()) }}
            </span>
        </div>
        <div class="cart">
            <a onclick="addToCartInList(this)"
               class="button {{ $productDay->inCart ? 'added' : '' }}"
               product_id="{{ $productDay->id }}"
               @if($productDay->inCart) href="/checkout" @endif>
                <span></span>
                <div class="add_to_cart_help">Товар в корзине</div>
            </a>
        </div>
        <div class="cl_b"></div>
    </div>
</div>
@endif