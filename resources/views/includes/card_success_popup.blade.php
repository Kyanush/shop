<div class="product_popup">
    <div class="product_popup_line"></div>
    <div class="product_popup_header">
        Вы добавили товар в корзину
        <div class="product_popup_close" onclick="es_close_temp_window()"></div>
    </div>
    <div class="product_show_info">
        <div class="product_show_info_left">
            <img src="{{ $product->pathPhoto(true) }}" alt="{{ $product->name }}" title="{{ $product->name }}"/>
        </div>
        <div class="product_show_info_middle">
            <div class="product_show_info_middle_name">
                {{ $product->name }}
            </div>
            <div class="product_show_info_middle_sku">Артикул <span>{{ $product->sku }}</span></div>
            <div class="product_show_info_middle_stock">
                @if($product->stock)
                    <span class="in_stock_icon">В наличии</span>
                @endif
            </div>
        </div>
        <div class="product_show_info_right">
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
        </div>
    </div>
    <div class="product_show_buttons">
        <a href="#" class="products_also">Продолжить покупки</a>
        <a href="/checkout" class="button" style="color: #fff;">
            <span>Оформить заказ</span>
        </a>
        <div class="cl_b"></div>
    </div>

    <span class="you-may-be-interested">
        @include('includes.product_slider', ['products' => $products_interested, 'title' => 'Вас может заинтересовать'])
    </span>



</div>