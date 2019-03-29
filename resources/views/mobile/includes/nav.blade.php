<nav class="kaspi-menu ">
    <div class="kaspi-menu__inner">


        <div class="kaspi-menu__header">
            <div class="mount-kaspi-menu-auth">
                <div class="kaspi-menu__signin">
                    <i class="kaspi-menu__signin-icon icon icon_user"></i>
                    <a style="color: #fff;text-decoration: none;" href="/login">Вход</a>
                    /
                    <a style="color: #fff;text-decoration: none;" href="/register">Регистрация</a>
                </div>
            </div>
            <!--
            <a href="#" class="kaspi-menu__region">
                <i class="kaspi-menu__region-icon"></i> Алматы
            </a>-->
        </div>

        <ul class="kaspi-menu__items">

            <?
               $menu = [
                   [
                       'title' => 'Главная',
                       'link'  => '/'
                   ],
                   [
                       'title' => 'Акции',
                       'link'  => '/specials'
                   ],
                   [
                       'title' => 'Доставка, оплата',
                       'link'  => '/delivery-payment'
                   ],
                   [
                       'title' => 'Гарантия',
                       'link'  => '/guaranty'
                   ],

                   [
                       'title' => 'Мои закладки',
                       'link'  => '/wishlist',
                   ],
                   [
                       'title' => 'Сравнение товаров',
                       'link'  => '/compare-products',
                   ],
                   [
                       'title' => 'Корзина',
                       'link'  => '/checkout',
                   ],
                   [
                       'title' => 'Контакты',
                       'link'  => '/contact'
                   ],
                   [
                       'title' => 'О нас',
                       'link' => '/about',
                   ]
               ];
            ?>

            @foreach($menu as $item)
                <li class="kaspi-menu__item @if(strpos($_SERVER['REQUEST_URI'], $item['link']) !== false && $item['link'] != '/') _active @endif">
                    <a class="kaspi-menu__itemLink" href="{{ $item['link'] }}">
                        {{ $item['title'] }}
                    </a>
                </li>
            @endforeach

            <!--
            <li class="kaspi-menu__item kaspi-menu__item-apps">
                <div class="kaspi-menu__apps">
                    <div class="kaspi-menu__apps-header">Мобильное приложение</div>
                    <a href="https://itunes.apple.com/app/id1195076505" data-app="iOS" target="_blank" class="kaspi-menu__apps-link">
                        <img class="kaspi-menu__apps-img" src="/medias/sys_master/images/images/h14/h76/9075485605918/appstore-2x.png" alt="appstore">
                    </a>
                    <a href="https://play.google.com/store/apps/details?id=kz.kaspi.mobile" data-app="Android" target="_blank" class="kaspi-menu__apps-link g-hide">
                        <img class="kaspi-menu__apps-img" src="/medias/sys_master/images/images/he2/h37/9075485573150/googleplay-2x.png" alt="google play">
                    </a>
                </div>
            </li>--->

        </ul>
    </div>
</nav>