<div id="footer">
    <div class="footer_line"></div>
    <div class="container">
        <div class="footer_column footer_column_1">
            <div id="footer_logo">
                <img class="footer_normal_logo"   src="{{ config('shop.logo') }}" title="{{ env('APP_NAME') }}" alt="{{ env('APP_NAME') }}">
            </div>
        </div>
        <div class="footer_column footer_column_2">
            <div class="footer_column_header">Покупателям</div>
            <ul>
                <li><a href="{{ route('delivery_payment') }}">Доставка</a></li>
                <li><a href="{{ route('delivery_payment') }}">Оплата</a></li>
                <li><a href="{{ route('guaranty') }}">Гарантия</a></li>
                <li><a href="{{ route('wishlist') }}">Мои закладки</a></li>
                <li><a href="{{ route('compare_products') }}">Сравнение товаров</a></li>
                <li><a href="{{ route('checkout') }}">Оформление заказа</a></li>
            </ul>
        </div>
        <div class="footer_column footer_column_3">
            <div class="footer_column_header">Каталог</div>
            <ul>
                <li><a href="/catalog/smartfony-xiaomi">Смартфоны Xiaomi</a></li>
                <li><a href="/catalog/gadzhety">Гаджеты и устройства</a></li>
                <li><a href="/catalog/transport">Электронный транспорт</a></li>
                <li><a href="/catalog/naushniki-i-kolonki">Наушники и колонки</a></li>
                <li><a href="/catalog/aksessuary">Аксессуары</a></li>
                <li><a href="/catalog/zaryadnye-ustroystva">Зарядные устройства</a></li>
            </ul>
        </div>
        <div class="footer_column footer_column_4">
            <div class="footer_column_header">О компании</div>
            <ul>
                <li><a href="{{ route('contact') }}">Контакты</a></li>
                <li><a href="{{ route('about') }}">О нас</a></li>
            </ul>
        </div>
        <div class="footer_bottom">
            <div class="footer_bottom_copyright">
                Copyright © 2018–{{ date('Y') }} {{ env('APP_NO_URL') }}<br>
                Все права защищены.			</div>
            <div class="footer_bottom_social">
                <div class="contact_block_social" style="padding: 0;">
                    <a href="{{ config('shop.social_network.instagram.url') }}" class="contact_in1" target="_blank" title="Вы в Instagram">
                        <img src="/site/images/insta.png" width="30">
                    </a>
                    <!--
                    <a href="https://vk.com/rumicomrussia" class="contact_vk" target="_blank"></a>
                    <a href="https://www.youtube.com/channel/UCvK29FNCSg46Eik86viJtjQ" class="contact_yt" target="_blank"></a>
                    <a href="https://t.me/joinchat/AAAAAEQXBI2_KCqGAIEV-Q" class="contact_tg" target="_blank"></a>
                    <a href="https://ok.ru/group/52288056197276" class="contact_ok" target="_blank"></a>
                    --->
                </div>
            </div>
            <div class="footer_bottom_text">
                Любое использование либо копирование материалов или подборки материалов сайта,<br>
                элементов дизайна и оформления может осуществляться лишь с разрешения автора<br>
                (правообладателя) и только при наличии ссылки на {{ env('APP_URL') }}
            </div>
        </div>
    </div>
</div>