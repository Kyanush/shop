<div id="header">
    <div id="header_top">
        <div class="container">
            <div class="contact">
                <span class="address">
                    <img src="/site/images/rumi_shops_link.png"/>
                    @php
                        $address = config('shop.address');
                        $number_phones = config('shop.number_phones');
                    @endphp
                    {{ $address[0]['addressLocality'] }}, {{ $address[0]['streetAddress'] }}
                </span>
                <span class="phone">
                    <img src="/site/images/callback_icon.png">
                    <a href="tel:{{ $number_phones[0]['number'] }}">
                        {{ $number_phones[0]['format'] }}
                    </a>
                </span>
            </div>
        </div>
    </div>

    <div id="header_top">
        <div class="container">
            <!--
            <div class="town_selector">
                Ваш город:
                <span class="town_moscow town_go_find" onclick="showCity()">

                </span>
            </div>
                        <div class="contact">
                            <span class="address"><img src="/site/images/rumi_shops_link.png"/> г. Алматы, ул. Жибек жолы 115, оф. 113 (Рядом Аэровокзала)</span>
                            <span class="phone">
                                <img src="/site/images/callback_icon.png">
                                <a href="tel:+77089619225">+7 (708) 961-92-25</a>
                            </span>
                        </div>
            --->
            <div id="welcome">
                @guest
                    <a class="header_login_enter" href="/login">Войти</a>
                    <a class="header_login_register" href="/register">Регистрация</a>
                @endguest
                @auth
                    Вы вошли как <a href="/my-account" class="login_link">{{ Auth::user()->name }}</a>
                    <b>(</b>
                    <a href="/logout">Выйти</a>
                    <b>)</b>
                @endauth
            </div>
        </div>
    </div>

    @include('site.includes.header_middle')

    @include('site.includes.header_menu')

</div>