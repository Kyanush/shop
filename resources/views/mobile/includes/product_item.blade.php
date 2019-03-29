<a class="item-card ddl_product ddl_product_link" href="{{ $product->detailUrlProduct() }}">
    <div class="item-card__sticker"></div>
    <div class="item-card__image-wrapper ddl_product_link">
        <img class="item-card__image" alt="{{ $product->name }}" src="{{ $product->pathPhoto(true) }}">
    </div>
    <div class="item-card__info">
        <h3 class="item-card__name">
            <div class="item-card__name-link">
                {{ $product->name }}
            </div>
        </h3>
        <div class="item-card__rating">
            <span class="rating _{{ ($product->avgRating->avg_rating ?? 0) * 2 }}"></span>

            <span class="rating-count">
                @if($product->reviews_count > 0)
                    <span>({{ $product->reviews_count }}<span class="rating-count__text">&nbsp;отзывов</span>)</span>
                @endif
            </span>

        </div>
        <div class="item-card__prices">
            <div class="item-card__debet">
                <span class="item-card__prices-title">Цена</span>
                <span class="item-card__prices-price">
                    {{ \App\Tools\Helpers::priceFormat($product->getReducedPrice()) }}
                </span>
            </div>
            <div class="item-card__instalment">
                <span class="item-card__prices-title">В рассрочку</span>
                <span class="item-card__prices-price">3 067 ₸</span>
                <span class="item-card__add-info"> x 3 мес </span>
            </div>
        </div>
    </div>
</a>