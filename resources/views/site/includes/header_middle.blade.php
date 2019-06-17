<div id="header_middle">
    <div class="container">
        <a id="logo" href="/">
            <img src="/site/images/logo.png" title="{{ env('APP_NAME') }}" alt="{{ env('APP_NAME') }}">
        </a>
        <a class="rumi_shops_link" href="/contact">
            <span>Магазины</span>
        </a>
        <div id="search">
            <div class="button-search"></div>
            <div class="search-close"></div>
            <input type="search" name="search" placeholder="Поиск по товарам, например Xiaomi" class="product-search-desktop" autocomplete="off">
        </div>
        <div id="header_phones">
            <a href="tel:{{ $number_phones[0]['number'] }}">
                <span class="phone_top">
                    {{ $number_phones[0]['format'] }}
                </span>
            </a>
            <div class="everyday_text">
                Круглосуточно
                <span class="callback_button"><span>Обратный звонок</span></span>
            </div>
        </div>
    </div>
</div>