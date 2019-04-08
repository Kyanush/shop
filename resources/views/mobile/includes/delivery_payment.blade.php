@include('mobile.includes.topbar', [
    'class'       => '_fixed',
    'title'       => '<a class="topbar__heading-link"><i class="topbar__heading-logo _icon"></i>Доставка, оплата</a>',
    'search_show' => false
])
@include('mobile.includes.space', ['style' => 'height: 3.073vw;'])

<div class="description container">
    @include('includes.delivery_payment_text')
</div>