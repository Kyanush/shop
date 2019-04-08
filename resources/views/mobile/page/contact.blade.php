@extends('layouts.mobile')

<?php $title = 'Контакты';?>
@section('title', $title)
@section('description', $title)
@section('keywords', $title)

@section('content')

    @include('mobile.includes.topbar', [
        'class'       => '_fixed',
        'title'       => '<a class="topbar__heading-link"><i class="topbar__heading-logo _icon"></i>' . $title . '</a>',
        'search_show' => false
    ])
    @include('mobile.includes.space', ['style' => 'height: 3.073vw;'])


    <div class="container">
        <p>
            Обсудить с нами возникшие вопросы или проконсультироваться звоните к нам по номеру:
            <a style="font-size: 14px;text-decoration: none;" href="tel:+77782002000">+7 (778) 200 20 00</a>,
            <a style="font-size: 14px;text-decoration: none;" href="tel:+77075511979">+7 (707) 551 1979</a>
            (ежедневно с 11-00 до 19-00).
            Кроме того, Вы можете отправить любые запросы или вопросы нам на электронную почту <a style="font-size: 14px;text-decoration: none;" href="mailto:info@onepoint.kz">info@onepoint.kz</a> ,
            не забудьте указать Ваше имя и контактные номера телефонов. Если Вас не устраивают какие-либо наши товары или услуги,
            мы с удовольствием выслушаем Вас. Мы всегда готовы решить проблему.
        </p>
        <p>
            <ul>
                <li>
                    <b>Телефоны:</b>
                    <br/>
                    Ежедневно, круглосуточно(телефон или WhatsApp)
                    <br/>
                    <a href="tel:+77782002000">+7 (778) 200 20 00</a>
                    <br/>
                    <a href="tel:+77075511979">+7 (707) 551 1979</a>
                </li>
                <li>
                    <b>Время работы:</b>
                    <br/>
                    c 10:00 до 19:00 Без выходных!
                </li>
                <li>
                    <b>Адрес:</b>
                    <br/>
                    г. Алматы, ул. Жибек жолы 115, оф. 113 (Рядом Аэровокзала)
                </li>
                <li>
                    <b>E-mail:</b>
                    <br/>
                    Вопросы по розничным продажам и.д.
                    <br/>
                    <a href="mailto:info@onepoint.kz">info@onepoint.kz</a>
                </li>

            </ul>
        </p>
        <p>
            <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A809d57a2d5e1595921eb0d4243f8faaa2748651e7ca204d04724d363036ff2ab&amp;source=constructor" width="100%" height="300" style="margin: 0;" frameborder="0"></iframe>
        </p>
    </div>

    @include('mobile.includes.footer')

@endsection