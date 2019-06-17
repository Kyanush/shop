<div id="callback" style="display: none;">
    <form action="javascript:void(null);" onsubmit="callback(this); return false;" method="post" enctype="multipart/form-data">
        @csrf
        <div class="callback_popup">
            <div class="callback_popup_line"></div>
            <div class="callback_popup_header">Обратный звонок
                <div class="callback_popup_close"></div>
            </div>
            <div class="callback_show_info">
                <div class="callback_show_text">
                    Введите номер телефона <span class="required">*</span>:
                </div>
                <div class="callback_show_input">

                    <input type="text"
                           name="phone"
                           class="phone-mask"
                           @auth
                           value="{{ Auth::user()->phone }}"
                           @endauth
                           placeholder="+7 (___) ___-__-__"/>

                    <span class="callback_phone_error"></span>
                </div>
            </div>
            <div class="callback_button" onclick="$(this).parents('form').submit()">
                <a href="#" class="callback_one_click button">
                    <span>
                         <img style="display: none" src="/site/images/ajax-loader.gif"/>
                        Заказать
                    </span>
                </a>
            </div>
        </div>
    </form>
</div>