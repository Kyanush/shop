@extends('layouts.site')

<?php $title = "Авторизация"; ?>
@section('title', $title)
@section('description', $title)
@section('keywords', $title)

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
                'title' => 'Логин',
                'link'  => ''
            ]
        ];?>
        @include('includes.breadcrumb', ['breadcrumb' => $breadcrumb])

        @include('includes.menu_left_my_account')

        <div id="content" style="overflow: visible;">
            <h1>{{ $title }}</h1>
            <div class="login-content">
                <div class="left">
                    <h2>Новый клиент</h2>
                    <div class="content">
                        <p><b>Регистрация</b></p>
                        <p>Создав учетную запись Вы сможетете быстрее оформлять заказы, отслеживать их статус и просматривать историю покупок.</p>
                        <a href="/register" class="button"><span>Продолжить</span></a></div>
                </div>
                <div class="right">
                    <h2>Зарегистрированный клиент</h2>

                    <form action="{{ route('login') }}" id="form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="content">
                            <p>Войти в Личный Кабинет</p>

                            <b>E-Mail:</b><br>
                            <input required autofocus type="text" class="{{ $errors->has('email') ? ' is-invalid' : '' }}"  name="email" value="{{ old('email') }}"/>
                            <br>
                            <br>

                            <b>Пароль:</b><br>
                            <input id="password" type="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            <br>
                            <a href="{{ route('password.request') }}">Забыли пароль?</a><br>
                            <br>
                            <a class="button" onclick="$(this).parents('form').submit()">
                                <span>Войти</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="cl_b"></div>

    </div>
   

@endsection
