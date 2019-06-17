@extends(\App\Tools\Helpers::isMobile() ? 'layouts.mobile' : 'layouts.site')

<?php $title = 'Забыли пароль?';?>
@section('title', $title)
@section('description', $title)
@section('keywords', $title)

@section('content')


@mobile
    @include('mobile.auth.passwords.email')
@elsemobile
    <div class="container">


        <?php $breadcrumbs = [
            [
                'title' => 'Главная',
                'link'  => '/'
            ],
            [
                'title' => $title,
                'link'  => ''
            ]
        ];?>
        @include('includes.breadcrumb', ['breadcrumbs' => $breadcrumbs])

        @if (session('status'))
            <div class="success">
                {{ session('status') }}
            </div>
        @endif


        <div id="content" style="overflow: visible;">  <h1>Забыли пароль?</h1>
            <form id="form" method="POST" action="{{ route('password.email') }}">
                @csrf


                <p>Введите адрес электронной почты Вашей учетной записи. Нажмите кнопку Вперед, чтобы получить пароль по электронной почте.</p>
                <h2>Ваш E-Mail</h2>
                <div class="content">
                    <table class="form">
                        <tbody><tr>
                            <td>E-Mail:</td>
                            <td>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                            </td>
                        </tr>
                        </tbody></table>
                </div>
                <div class="buttons">
                    <div class="left">
                        <a href="/login" class="button">
                            <span>Назад</span>
                        </a>
                    </div>
                    <div class="right">
                        <a class="button" onclick="$('#form').submit();"><span>Продолжить</span></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endmobile

@endsection