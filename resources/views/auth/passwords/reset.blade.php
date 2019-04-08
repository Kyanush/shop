@extends(\App\Tools\Helpers::isMobile() ? 'layouts.mobile' : 'layouts.site')

<?php $title = 'Сброс пароля';?>
@section('title',       $title)
@section('description', $title)
@section('keywords',    $title)

@section('content')

@mobile
    @include('mobile.auth.passwords.reset')
@elsemobile
    <div class="container">


            <?php $breadcrumb = [
                [
                    'title' => 'Главная',
                    'link'  => '/'
                ],
                [
                    'title' => $title,
                    'link'  => ''
                ]
            ];?>
            @include('includes.breadcrumb', ['breadcrumb' => $breadcrumb])

        <div id="content" style="overflow: visible;">  <h1>Забыли пароль?</h1>
            <form id="form" method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="content">
                    <table class="form">
                        <tbody>
                            <tr>
                                <td>Адрес электронной почты:</td>
                                <td>
                                    <input id="email" type="email"  name="email" value="{{ $email ?? old('email') }}" required autofocus/>
                                </td>
                            </tr>
                            <tr>
                                <td>Пароль:</td>
                                <td>
                                    <input id="password" type="password" name="password" required/>
                                </td>
                            </tr>
                            <tr>
                                <td>Подтвердите Пароль:</td>
                                <td>
                                    <input id="password-confirm" type="password" name="password_confirmation" required/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="buttons">
                    <div class="left">
                        <a href="/login" class="button">
                            <span>Назад</span>
                        </a>
                    </div>
                    <div class="right">
                        <a class="button" onclick="$('#form').submit();">
                            <span>Сброс пароля</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
</div>
@endmobile

@endsection
