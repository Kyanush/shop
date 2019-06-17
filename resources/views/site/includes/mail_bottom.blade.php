<div class="mail_bottom">
    <div class="mail_bottom_bg"></div>
    <div class="mail_bottom_content">
        <form action="javascript:void(null);" onsubmit="subscribe(this); return false;" method="post" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="mail_footer_logo"></div>
                <div class="mail_footer_text">
                    <span class="mail_footer_text_main">Будь в курсе последних предложений</span>
                    <span class="mail_footer_text_sub">Подпишись и получай информацию об акциях и скидках</span>
                </div>
                <div class="mail_footer_inputspace">
                    <input type="email"
                           name="email"
                           id="mail_footer_button"
                           placeholder="Введите ваш e-mail"/>
                </div>
                <div class="mail_footer_button" onclick="$(this).parents('form').submit()">
                    <span>Подписаться</span>
                </div>
            </div>
        </form>
    </div>
    <div class="mail_bottom_bg"></div>
</div>