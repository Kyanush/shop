@extends('layouts.site')

@section('title', 'Регистрация в интернет магазине ' . env('APP_NAME'))
@section('description', 'Регистрация в интернет магазине ' . env('APP_NAME'))
@section('keywords', 'Регистрация в интернет магазине ' . env('APP_NAME'))

@section('content')

<div class="container">
    <?php $breadcrumb = [
        [
            'title' => 'Главная',
            'link'  => '/'
        ],
        [
            'title' => 'Личный кабинет',
            'link'  => '/my-account'
        ],
        [
            'title' => 'Регистрация',
            'link'  => ''
        ]
    ];?>
    @include('includes.breadcrumb', ['breadcrumb' => $breadcrumb])


    @include('includes.menu_left_my_account')


    <div id="content" style="background: none; padding: 0px; overflow: visible;">
        <h1>Регистрация</h1>
        <div class="simple-content">
            <form id="register" action="{{ route('register') }}" method="post" enctype="multipart/form-data" id="simplepage_form">
                @csrf
                <div class="simpleregister" id="simpleregister">
                    <p class="simpleregister-have-account">
                        Если Вы уже зарегистрированы, перейдите на страницу <a href="/login">входа в систему</a>.
                    </p>
                    <div class="simpleregister-block-content">
                        <table class="simplecheckout-table-form">
                            <tbody>
                                <tr class="row-register_email">
                                    <td class="simplecheckout-table-form-left">
                                        <span class="simplecheckout-required">*</span>
                                        Email
                                    </td>
                                    <td class="simplecheckout-table-form-right">

                                        <input id="register_email"
                                               type="email"
                                               placeholder="Электронная почта *"
                                               name="email"
                                               value="{{ old('email') }}"
                                               required>

                                        <div class="simplecheckout-rule-group"></div>
                                    </td>
                                </tr>
                                <tr class="row-register_password">
                                    <td class="simplecheckout-table-form-left">
                                        Пароль
                                    </td>
                                    <td class="simplecheckout-table-form-right">

                                        <input id="password"
                                               placeholder="Пароль *"
                                               id="register_password"
                                               type="password"
                                               name="password"
                                               required>

                                        <div class="simplecheckout-rule-group"></div>
                                    </td>
                                </tr>

                                <tr class="row-register_password">
                                    <td class="simplecheckout-table-form-left">
                                        Повторите пароль
                                    </td>
                                    <td class="simplecheckout-table-form-right">

                                        <input
                                               placeholder="Повторите пароль *"
                                               id="register_password"
                                               type="password"
                                               name="password_confirmation"
                                               required>

                                        <div class="simplecheckout-rule-group"></div>
                                    </td>
                                </tr>

                                <tr class="row-register_name">
                                    <td class="simplecheckout-table-form-left">
                                        Имя
                                    </td>
                                    <td class="simplecheckout-table-form-right">
                                        <input
                                                type="text"
                                                name="name"
                                                id="register_name"
                                                value="{{ old('name') }}"
                                                placeholder="Имя *">
                                        <div class="simplecheckout-rule-group"></div>
                                    </td>
                                </tr>

                                <tr class="row-register_phone">
                                    <td class="simplecheckout-table-form-left">
                                        <span class="simplecheckout-required">*</span>
                                        Телефон
                                    </td>
                                    <td class="simplecheckout-table-form-right">
                                        <input
                                                type="tel"
                                                name="phone"
                                                id="register_phone"
                                                class="phone-mask"
                                                value="{{ old('phone') }}"
                                                placeholder="Мобильный телефон *">
                                        <div class="simplecheckout-rule-group"></div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="simpleregister-button-block buttons">
                        <div class="simpleregister-button-right">
                            <a onclick="$('#register').submit()" class="button">
                                <span>Продолжить</span>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
