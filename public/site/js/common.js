window.addEventListener("load", function(event) {
    lazyload();
});
function setScrollAttrs() {
    if (jQuery('.product_tabs_content').length && jQuery('.tab_attribute_left').length) {
        jQuery('.tab_attribute_left').addClass("tab_attribute_left_fixed");
        if (jQuery(window).scrollTop() > jQuery('.product_tabs_content').offset().top+12) {
            jQuery('.tab_attribute_left').addClass("tab_attribute_left_fixed");
        } else {
            jQuery('.tab_attribute_left').removeClass("tab_attribute_left_fixed");
        }

        var bottom_y_last_block = parseInt(jQuery('.product_tabs_content').offset().top) + parseInt(jQuery('.product_tabs_content').height()); // РЅРёР¶РЅСЏСЏ С‚РѕС‡РєР°
        var cart_y_height = parseInt(jQuery('.tab_attribute_left').offset().top) + parseInt(jQuery('.tab_attribute_left').height()); // РЅРёР¶РЅСЏСЏ С‚РѕС‡РєР°

        if (cart_y_height>bottom_y_last_block) {
            jQuery('.tab_attribute_left').removeClass("tab_attribute_left_fixed");
        }
    }
}

$(document).click( function(event){
    if( $(event.target).closest(".podskazka").length )
        return;
    $(".podskazka>span").hide();
    event.stopPropagation();
});

function set_go_top() {

    var bottom_height = parseInt(jQuery('.mail_bottom').height())+parseInt(jQuery('#footer').height());

    var bottom_position = jQuery(document).height()-jQuery(window).height()-jQuery(window).scrollTop();

    if (bottom_position < bottom_height-80)
    {
        jQuery('#go_top').css('bottom',-bottom_position+bottom_height-25+'px');
    }
    else
    {
        jQuery('#go_top').css('bottom','80px');
    }

    var st = jQuery(window).scrollTop();
    if ( st > 200 )
        jQuery('#go_top').css('opacity','0.8');
    else
        jQuery('#go_top').css('opacity','0');
}

$(document).ready(function() {

    /* super menu */
    $('#header #menu > ul > li > a').live('click', function() {
        if (window.innerWidth<820) {
            if( $(event.target).closest("span").length ) {
                return true;
            }
            else
            {
                if ($(this).next().hasClass('mini_menu_opened'))
                {
                    $(this).removeClass('active_a_main');
                    $(this).next().removeClass('mini_menu_opened');
                }
                else
                {
                    $('#header #menu > ul > li > a.active_a_main').removeClass('active_a_main');
                    $('#header #menu > ul > li > div.mini_menu_opened').removeClass('mini_menu_opened');
                    $(this).addClass('active_a_main');
                    $(this).next().addClass('mini_menu_opened');
                    return false;
                }
                return false;
            }
        };
    });

    $('#header #menu > ul > li > div > ul > li > a.level2_can_opened').live('click', function() {
        if (window.innerWidth<820) {
            if( $(event.target).closest("span").length ) {
                return true;
            }
            else
            {
                if ($(this).next().hasClass('mini2_menu_opened'))
                {
                    $(this).removeClass('active2_a_main');
                    $(this).next().removeClass('mini2_menu_opened');
                }
                else
                {
                    $(this).addClass('active2_a_main');
                    $(this).next().addClass('mini2_menu_opened');
                }
                return false;
            }
        };
    });

    $('.box-cat .box-cat-category li .category_open_also').live('click', function() {
        if ($(this).hasClass('category_open_also_active'))
        {
            $(this).removeClass('category_open_also_active');
            $(this).next().find('ul').css('display','none');
        }
        else
        {
            $(this).addClass('category_open_also_active');
            $(this).next().find('ul').css('display','block');
        }
    });

    $(document).keydown(function(e) {
        if( e.keyCode === 27 ) {
            $('.mail_grey_bg').css('display','none');
            $('.mail_popup').css('display','none');
            $('.popup_grey_bg').css('display','none');
            $('.popup').css('display','none');
            $('.videopopup_grey_bg').css('display','none');
            $('.videopopup').css('display','none');
            $('.shippingpopup_grey_bg').css('display','none');
            $('.shippingpopup').css('display','none');
            $('.callback_grey_bg').css('display','none');
            $('.callback_popup').css('display','none');
            $('.oneclick_grey_bg').css('display','none');
            $('.oneclick_popup').css('display','none');
            $('.question_grey_bg').css('display','none');
            $('.question_popup').css('display','none');
            $('.review_grey_bg').css('display','none');
            $('.review_popup').css('display','none');
            $('.product_grey_bg').css('display','none');
            setTimeout(fadeoutadded, 1000);
            $('.product_popup').css('display','none');
            $('.picturepopup_grey_bg').css('display','none');
            $('.picturepopup').css('display','none');
            $('.picturepopup_width').css('display','none');
            $('.instagram_bg').css('display','none');
            $('.instagram_popup').css('display','none');
            return false;
        }
    });

    $('#filterpro .option_name .podskazka, #filterpro .attribute_group_name .podskazka').live('click', function() {
        var x = 0;
        if ($(this).find('span').css('display')=='block')
            x = 0;
        else
            x = 1;
        $('#filterpro .option_name .podskazka > span').css('display','none');
        if (x==0)
            $(this).find('span').css('display','none');
        else
            $(this).find('span').css('display','block');

        return false;
    });

    $('.callback_one_click').live('click', function() {
        var	intRegex = /[0-9 -()+]+$/;

        $('.callback_phone_error').html('');

        if ($('.callback_one_click').hasClass('disabled')) {
            return;
        }

        phone = $('input[name="callback_phone"]').val();

        if((phone.length < 4) || (!intRegex.test(phone))){
            $('.callback_phone_error').html('РќРµРІРµСЂРЅС‹Р№ С„РѕСЂРјР°С‚ РЅРѕРјРµСЂР°.');
            return false;
            return;
        }

        $.ajax({
            type:'post',
            url:'index.php?route=module/oneclick/callback',
            data:'phone='+phone,
            dataType:'json',
            beforeSend: function() {
                $('.callback_one_click').addClass('disabled');
                $('.callback_one_click').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
            },
            complete: function() {
                $('.callback_one_click').removeClass('disabled');
                $('.wait').remove();
            },
            success:function(data){
                $('.callback_show_info').html('<span style="font-size: 14px;display: inline-block;margin: 10px 0;line-height: 20px;">'+data['success']+'</span>');
                $('.callback_popup .callback_button').remove();
                roistat.event.send('callback_one_click');
            }
        });

        return false;
    });

    $(window).scroll(function() {
        set_go_top();
    });
    set_go_top();

    $('#go_top').live('click', function() {
        $('html, body').animate({scrollTop:0}, 500);
    });

    $('.mail_footer_button').live('click', function() {

        var email = $('#mail_footer_button').val();

        var regex = /^([a-zA-Z0-9_.+-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
        if(regex.test(email)) {
            $.ajax({
                url: 'index.php?route=module/welcome/emailsend',
                type: 'post',
                data: 'email=' + email,
                success: function(html) {
                    rrApi.welcomeSequence(email);
                    $('.mail_show_info').html(html);
                    $('.mail_grey_bg').css('display','block');
                    $('.mail_popup').css('display','block');
                }
            });
        }
        else
        {
            $('.mail_show_info').html('Р’РІРµРґРёС‚Рµ РєРѕСЂСЂРµРєС‚РЅС‹Р№ e-mail!');
            $('.mail_grey_bg').css('display','block');
            $('.mail_popup').css('display','block');
        }


    });

    $('.external_link').each(function(){
        var classes = $(this).attr('class');
        var data_link = $(this).attr('data_link');
        $(this).replaceWith(function(){return '<a class="'+classes+'" href="'+data_link+'" target="_blank">'+$(this).html()+'</a>';})
    });

    $('#search_adaptive_icon').live('click', function() {
        $('.search_adaptive_line').css('display','block');
        $('#cart').css('display','none');
    });

    $('.search-close2').live('click', function() {
        $('.search_adaptive_line').css('display','none');
        $('#cart').css('display','block');
    });

    $('#cart-total').live('click', function() {
        location.href = "/cart/";
    });

    $('.header_top_adaptive_menu').live('click', function() {
        $('.header_top_adaptive_menu_inner').css('display','block');
    });

    $('.header_top_adaptive_menu_closed').live('click', function() {
        $('.header_top_adaptive_menu_inner').css('display','none');
    });

    $('.header_top_adaptive_menu_go_close').live('click', function() {
        $('.header_top_adaptive_menu_inner').css('display','none');
    });

    $('.town_popup_enter_close').live('click', function() {
        $('#main_city').val('');
    });

    $(window).scroll(function() {
        setScrollAttrs();
    });
    setScrollAttrs();

    $('.town_popup_list ul li a').live('click', function() {
        var town = $(this).text();
        $.ajax({
            url: 'index.php?route=module/town/settown',
            type: 'get',
            data: 'town=' + town,
            success: function(html) {
                window.location.reload();
            }
        });
        return false;
    });

    $('.set_country').live('click', function() {
        var town = $(this).attr('country_name');
        $.ajax({
            url: 'index.php?route=module/town/settown',
            type: 'get',
            data: 'town=' + town,
            success: function(html) {
                window.location.reload();
            }
        });
        return false;
    });

    $('.town_grey_bg').live('click', function() {
        $('.town_grey_bg').css('display','none');
        $('.town_popup').css('display','none');
    });

    $('.town_popup_close').live('click', function() {
        $('.town_grey_bg').css('display','none');
        $('.town_popup').css('display','none');
    });

    $('.popup_grey_bg').live('click', function() {
        $('.popup_grey_bg').css('display','none');
        $('.popup').css('display','none');
    });

    $('.popup_close').live('click', function() {
        $('.popup_grey_bg').css('display','none');
        $('.popup').css('display','none');
    });

    $('.videolink').live('click', function() {
        var href = $(this).attr('href');
        $('.videopopup .show_info iframe').attr('src',href);
        $('.videopopup_grey_bg').css('display','block');
        $('.videopopup').css('display','block');
        return false;
    });

    $('.videopopup_grey_bg').live('click', function() {
        $('.videopopup_grey_bg').css('display','none');
        $('.videopopup').css('display','none');
    });

    $('.videopopup_close').live('click', function() {
        $('.videopopup_grey_bg').css('display','none');
        $('.videopopup').css('display','none');
    });

    $('.picture_grey_bg').live('click', function() {
        $('.picture_grey_bg').css('display','none');
        $('.picturepopup').css('display','none');
        $('.picturepopup_width').css('display','none');
    });

    $('.picturepopup_close').live('click', function() {
        $('.picture_grey_bg').css('display','none');
        $('.picturepopup').css('display','none');
        $('.picturepopup_width').css('display','none');
    });

    $('.instagram_bg').live('click', function() {
        $('.instagram_popup').css('display','none');
        $('.instagram_bg').css('display','none');
    });

    $('.instagram_popup_close').live('click', function() {
        $('.instagram_popup').css('display','none');
        $('.instagram_bg').css('display','none');
    });

    $('.town_go_find').live('click', function() {
        var body = document.body;
        var docEl = document.documentElement;
        if (window.innerWidth<820) {
            scrollTop = parseInt(window.pageYOffset || docEl.scrollTop || body.scrollTop);
            $('.town_popup').css('margin-top','0');
            $('.town_popup').css('top',scrollTop+100+'px');
        }
        else
        {
            $('.town_popup').css('margin-top','-250px');
            $('.town_popup').css('top','50%');
        }
        $('.town_grey_bg').css('display','block');
        $('.town_popup').css('display','block');
    });

    $('.review_grey_bg').live('click', function() {
        $('.review_grey_bg').css('display','none');
        $('.review_popup').css('display','none');
    });

    $('.review_popup_close').live('click', function() {
        $('.review_grey_bg').css('display','none');
        $('.review_popup').css('display','none');
    });

    $('.write_review').live('click', function() {
        $('.review_grey_bg').css('display','block');
        $('.review_popup').css('display','block');
        return false;
    });

    $('.question_grey_bg').live('click', function() {
        $('.question_grey_bg').css('display','none');
        $('.question_popup').css('display','none');
    });

    $('.question_popup_close').live('click', function() {
        $('.question_grey_bg').css('display','none');
        $('.question_popup').css('display','none');
    });

    $('.write_question').live('click', function() {
        $('.question_grey_bg').css('display','block');
        $('.question_popup').css('display','block');
        return false;
    });

    $('.product_grey_bg').live('click', function() {
        $('.product_grey_bg').css('display','none');
        setTimeout(fadeoutadded, 1000);
        $('.product_popup').css('display','none');
    });

    $('.product_popup_close').live('click', function() {
        $('.product_grey_bg').css('display','none');
        setTimeout(fadeoutadded, 1000);
        $('.product_popup').css('display','none');
    });

    $('.mail_grey_bg').live('click', function() {
        $('.mail_grey_bg').css('display','none');
        $('.mail_popup').css('display','none');
    });

    $('.mail_popup_close').live('click', function() {
        $('.mail_grey_bg').css('display','none');
        $('.mail_popup').css('display','none');
    });

    $('.products_also').live('click', function() {
        $('.product_grey_bg').css('display','none');
        setTimeout(fadeoutadded, 1000);
        $('.product_popup').css('display','none');
        return false;
    });

    $('#oneclick_button_send').live('click', function() {
        $('.oneclick_phone_error').html('');
        $('.oneclick_grey_bg').css('display','block');
        $('.oneclick_popup').css('display','block');
        return false;
    });

    $('.callback_button').live('click', function() {
        var href = $(this).attr('href');
        $('.callback_grey_bg').css('display','block');
        $('.callback_popup').css('display','block');
        return false;
    });

    $('.callback_grey_bg').live('click', function() {
        $('.callback_grey_bg').css('display','none');
        $('.callback_popup').css('display','none');
    });

    $('.callback_popup_close').live('click', function() {
        $('.callback_grey_bg').css('display','none');
        $('.callback_popup').css('display','none');
    });

    if(!is_mobile()){
        $("input[name='callback_phone']").mask("+7 (999) 999-9999");
    };

    $('.infopage_box_show_cost_button').live('click', function() {

        var town = $('input[name="town"]').val();

        $.ajax({
            url: 'index.php?route=information/infopage/shippingtarif',
            type: 'post',
            data: 'town=' + town,
            success: function(html) {
                $('.shippingpopup .show_info').html(html);
                $('.shippingpopup_grey_bg').css('display','block');
                $('.shippingpopup').css('display','block');
            }
        });
    });

    $('shippingpopup_grey_bg').live('click', function() {
        $('.shippingpopup_grey_bg').css('display','none');
        $('.shippingpopup').css('display','none');
    });

    $('.shippingpopup_close').live('click', function() {
        $('.shippingpopup_grey_bg').css('display','none');
        $('.shippingpopup').css('display','none');
    });

    $('.oneclick_grey_bg').live('click', function() {
        $('.oneclick_grey_bg').css('display','none');
        $('.oneclick_popup').css('display','none');
    });

    $('.oneclick_popup_close').live('click', function() {
        $('.oneclick_grey_bg').css('display','none');
        $('.oneclick_popup').css('display','none');
    });

    $('#menu_categories').live('mouseenter', function(e) {
        if (window.innerWidth>=820)
        {
            $('.grey_bg').fadeIn(200);
            $('#menu').fadeIn(100,function(){});
            $('#menu_categories_selector').addClass('menu_categories_selector_active');
        }
    });

    $('#menu_categories_selector').live('click', function(e) {
        if (window.innerWidth<820)
        {
            if (!$(this).find('.menu_categories_selector_active').length)
            {
                $('.grey_bg').fadeIn(200);
                $('#menu').fadeIn(100,function(){});
                $('#menu_categories_selector').addClass('menu_categories_selector_active');
            }
        }
    });

    $('.menu_categories_selector_active').live('click', function(e) {
        $('.grey_bg').css('display','none');
        $('#menu').css('display','none');
        $('#menu_categories_selector').removeClass('menu_categories_selector_active');
    });

    function func() {
        if ($('.grey_bg').is(":hover")) {
            $('.grey_bg').css('display','none');
            $('#menu').css('display','none');
            $('#menu_categories_selector').removeClass('menu_categories_selector_active');
        }
    }

    $('.grey_bg').live('mouseenter', function(e) {
        setTimeout(func, 50);
    });

    /*
    $('.product-filter .sort > div').live('click', function(e) {
        var sort = $(this).attr('sort');
        var order = $(this).attr('order');
        var selected_value = 0;
        if (sort=='p.viewed' && order=='DESC') { selected_value = 1; $('.product-filter .sort > div').removeClass('sort_active'); $(this).addClass('sort_active'); $(this).removeClass('sort_asc'); $(this).removeClass('sort_desc'); $(this).addClass('sort_asc'); $(this).attr('order','ASC'); }
        if (sort=='p.viewed' && order=='ASC') { selected_value = 2; $('.product-filter .sort > div').removeClass('sort_active'); $(this).addClass('sort_active'); $(this).removeClass('sort_asc'); $(this).removeClass('sort_desc'); $(this).addClass('sort_desc'); $(this).attr('order','DESC'); }
        if (sort=='pd.name' && order=='ASC') { selected_value = 3; $('.product-filter .sort > div').removeClass('sort_active'); $(this).addClass('sort_active'); $(this).removeClass('sort_asc'); $(this).removeClass('sort_desc'); $(this).addClass('sort_desc'); $(this).attr('order','DESC'); }
        if (sort=='pd.name' && order=='DESC') { selected_value = 4; $('.product-filter .sort > div').removeClass('sort_active'); $(this).addClass('sort_active'); $(this).removeClass('sort_asc'); $(this).removeClass('sort_desc'); $(this).addClass('sort_asc'); $(this).attr('order','ASC'); }
        if (sort=='p.price' && order=='ASC') { selected_value = 5; $('.product-filter .sort > div').removeClass('sort_active'); $(this).addClass('sort_active'); $(this).removeClass('sort_asc'); $(this).removeClass('sort_desc'); $(this).addClass('sort_desc'); $(this).attr('order','DESC'); }
        if (sort=='p.price' && order=='DESC') { selected_value = 6; $('.product-filter .sort > div').removeClass('sort_active'); $(this).addClass('sort_active'); $(this).removeClass('sort_asc'); $(this).removeClass('sort_desc'); $(this).addClass('sort_asc'); $(this).attr('order','ASC'); }
        if (sort=='ps.price' && order=='ASC') { selected_value = 5; $('.product-filter .sort > div').removeClass('sort_active'); $(this).addClass('sort_active'); $(this).removeClass('sort_asc'); $(this).removeClass('sort_desc'); $(this).addClass('sort_desc'); $(this).attr('order','DESC'); }
        if (sort=='ps.price' && order=='DESC') { selected_value = 6; $('.product-filter .sort > div').removeClass('sort_active'); $(this).addClass('sort_active'); $(this).removeClass('sort_asc'); $(this).removeClass('sort_desc'); $(this).addClass('sort_asc'); $(this).attr('order','ASC'); }
        if (selected_value!=0)
        {
            $('.sort_select option:nth-child('+selected_value+')').prop('selected', true).attr('selected', 'true');
            $('.sort_select').change();
        }
    });*/

    $('#header #menu > ul > li').live('mouseenter', function(e) {
        $(this).parent().parent().addClass('menu_id_active');
    });

    $('#header #menu > ul > li').live('mouseleave', function(e) {
        $(this).parent().parent().removeClass('menu_id_active');
    });

    /* Search */
    $('.button-search').bind('click', function() {
        url = $('base').attr('href') + 'index.php?route=product/search';

        var search = $('input[name=\'search\']').attr('value').replace(/[^A-Za-zРђ-РЇР°-СЏРЃС‘0-9-\s]/g, "");

        if (search) {
            url += '&search=' + encodeURIComponent(search);
        }

        location = url;
    });

    $('.button-search2').bind('click', function() {
        url = $('base').attr('href') + 'index.php?route=product/search';

        var search = $('input[name=\'search2\']').attr('value').replace(/[^A-Za-zРђ-РЇР°-СЏРЃС‘0-9-\s]/g, "");

        if (search) {
            url += '&search=' + encodeURIComponent(search);
        }

        location = url;
    });

    $('#header input[name=\'search\']').bind('keydown', function(e) {
        if (e.keyCode == 13) {
            url = $('base').attr('href') + 'index.php?route=product/search';

            var search = $('input[name=\'search\']').attr('value').replace(/[^A-Za-zРђ-РЇР°-СЏРЃС‘0-9-\s]/g, "");

            if (search) {
                url += '&search=' + encodeURIComponent(search);
            }

            location = url;
        }
    });

    /* Ajax Cart */
    $('#cart > .heading a').live('mouseenter', function() {
        $('#cart').addClass('active');

        $('#cart').load('index.php?route=module/cart #cart > *');
    });

    $('#cart').live('mouseleave', function() {
        $(this).removeClass('active');
    });

    $('.success img, .warning img, .attention img, .information img').live('click', function() {
        $(this).parent().fadeOut('slow', function() {
            $(this).remove();
        });
    });
});

function getURLVar(key) {
    var value = [];

    var query = String(document.location).split('?');

    if (query[1]) {
        var part = query[1].split('&');

        for (i = 0; i < part.length; i++) {
            var data = part[i].split('=');

            if (data[0] && data[1]) {
                value[data[0]] = data[1];
            }
        }

        if (value[key]) {
            return value[key];
        } else {
            return '';
        }
    }
}

function addToCart(product_id, quantity) {
    quantity = typeof(quantity) != 'undefined' ? quantity : 1;

    $('.product_rostest').css('display','none');
    $('.product_global').css('display','none');
    $('.product_inner').parent().css('overflow','visible');

    $('.add_to_cart_'+product_id).addClass('added');
    $('.add_to_cart_'+product_id).attr('onclick','location.href="/checkout/"');
    $('.add_to_cart_'+product_id).find('.add_to_cart_help').fadeIn(300);

    $.ajax({
        url: 'index.php?route=checkout/cart/add',
        type: 'post',
        data: 'product_id=' + product_id + '&quantity=' + quantity,
        dataType: 'json',
        success: function(json) {
            $('.success, .warning, .attention, .information, .error').remove();

            if (json['redirect']) {
                location = json['redirect'];
            }

            if (json['success']) {
                yaCounter26740743.reachGoal('add_to_cart_yandex');
                $('#cart-total').html(json['total']);
                $('#header #cart .heading').addClass('heading_active');
                $('.product_popup .product_show_info').html(json['success']);
                $('.product_grey_bg').css('display','block');
                $('.product_popup').css('display','block');
                $('.rr_block').attr('data-product-id',json['products']);
                $('.rrblock_product').removeAttr('initialized');
                retailrocket.markup.render();
                fbq('track', 'AddToCart', {
                    value: json['price'],
                    currency: 'RUB',
                    content_ids: [product_id],
                    content_type: 'product',
                });
            }
        }
    });
}
function addToWishList(product_id) {
    var this_var = $(this);

    if (this_var.hasClass('active')) {
        $.ajax({
            url: 'index.php?route=account/wishlist/remove',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            success: function(json) {
                $('.header_wishlist span').html(json['total']);
                $('.success, .warning, .attention, .information').remove();
                this_var.removeClass('active');
            }
        });
    }
    else
    {
        $.ajax({
            url: 'index.php?route=account/wishlist/add',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            success: function(json) {
                $('.success, .warning, .attention, .information').remove();

                if (json['success']) {
                    if (json['added']==1) {
                        this_var.addClass('active');
                    }
                    $('.header_wishlist span').html(json['total']);
                    $('.popup .popup_header').html('Р—Р°РєР»Р°РґРєРё<div class="popup_close"></div>');
                    $('.popup .show_info').html(json['success']);
                    $('.popup_grey_bg').css('display','block');
                    $('.popup').css('display','block');
                }
            }
        });
    }
}

function addToCompare(product_id) {
    var this_var = $(this);

    if (this_var.hasClass('active')) {
        $.ajax({
            url: 'index.php?route=product/compare/remove',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            success: function(json) {
                $('.header_compare span').html(json['total']);
                if (json['total']=='0')
                    $('.header_compare').addClass('non_active');
                else
                    $('.header_compare').removeClass('non_active');
                $('.success, .warning, .attention, .information').remove();
                this_var.removeClass('active');
            }
        });
    }
    else
    {
        $.ajax({
            url: 'index.php?route=product/compare/add',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            success: function(json) {
                $('.success, .warning, .attention, .information').remove();

                if (json['success']) {
                    this_var.addClass('active');
                    $('.header_compare span').html(json['total']);
                    if (json['total']=='0')
                        $('.header_compare').addClass('non_active');
                    else
                        $('.header_compare').removeClass('non_active');
                    $('.popup .popup_header').html('РЎСЂР°РІРЅРµРЅРёРµ С‚РѕРІР°СЂРѕРІ<div class="popup_close"></div>');
                    $('.popup .show_info').html(json['success']);
                    $('.popup_grey_bg').css('display','block');
                    $('.popup').css('display','block');
                }
            }
        });
    }
}

$('.product_features_wishlist,.product_icons_wishlist').live('click', function() {
    var product_id = $(this).attr('product_id');
    var this_var = $(this);

    if (this_var.hasClass('active')) {
        $.ajax({
            url: 'index.php?route=account/wishlist/remove',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            success: function(json) {
                $('.header_wishlist span').html(json['total']);
                if (json['total']=='0')
                    $('.header_wishlist').addClass('non_active');
                else
                    $('.header_wishlist').removeClass('non_active');
                $('.success, .warning, .attention, .information').remove();
                this_var.removeClass('active');
            }
        });
    }
    else
    {
        $.ajax({
            url: 'index.php?route=account/wishlist/add',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            success: function(json) {
                $('.success, .warning, .attention, .information').remove();

                if (json['success']) {
                    if (json['added']==1) {
                        this_var.addClass('active');
                    }
                    $('.header_wishlist span').html(json['total']);
                    if (json['total']=='0')
                        $('.header_wishlist').addClass('non_active');
                    else
                        $('.header_wishlist').removeClass('non_active');
                    $('.popup .popup_header').html('Р—Р°РєР»Р°РґРєРё<div class="popup_close"></div>');
                    $('.popup .show_info').html(json['success']);
                    $('.popup_grey_bg').css('display','block');
                    $('.popup').css('display','block');
                }
            }
        });
    }

    return false;
});
/*
$('.product_features_compare,.product_icons_compare').live('click', function() {
    var product_id = $(this).attr('product_id');
    var this_var = $(this);

    if (this_var.hasClass('active')) {
        $.ajax({
            url: 'index.php?route=product/compare/remove',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            success: function(json) {
                $('.header_compare span').html(json['total']);
                if (json['total']=='0')
                    $('.header_compare').addClass('non_active');
                else
                    $('.header_compare').removeClass('non_active');
                $('.success, .warning, .attention, .information').remove();
                this_var.removeClass('active');
            }
        });
    }
    else
    {
        $.ajax({
            url: 'index.php?route=product/compare/add',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            success: function(json) {
                $('.success, .warning, .attention, .information').remove();

                if (json['success']) {
                    this_var.addClass('active');
                    $('.header_compare span').html(json['total']);
                    if (json['total']=='0')
                        $('.header_compare').addClass('non_active');
                    else
                        $('.header_compare').removeClass('non_active');
                    $('.popup .popup_header').html('РЎСЂР°РІРЅРµРЅРёРµ С‚РѕРІР°СЂРѕРІ<div class="popup_close"></div>');
                    $('.popup .show_info').html(json['success']);
                    $('.popup_grey_bg').css('display','block');
                    $('.popup').css('display','block');
                }
            }
        });
    }

    return false;
});
*/
$('.product_sticker_global').live('click', function() {
    $(this).parent().parent().parent().parent().css('overflow','hidden');
    $('.product_rostest').animate({top: "0"}, 200);
    $('.product_global').animate({top: "0"}, 200);
    $(this).parent().find('.product_global').css('display','block');
    $(this).parent().find('.product_global').css('top','-55%');
    $(this).parent().find('.product_global').animate({top: "0"}, 200);
});

$('.product_sticker_rostest').live('click', function() {
    $(this).parent().parent().parent().parent().css('overflow','hidden');
    $('.product_rostest').animate({top: "0"}, 200);
    $('.product_global').animate({top: "0"}, 200);
    $(this).parent().find('.product_rostest').css('display','block');
    $(this).parent().find('.product_rostest').css('top','-55%');
    $(this).parent().find('.product_rostest').animate({top: "0"}, 200);
});

$('.product_global_close').live('click', function() {
    $('.product_rostest').animate({top: "-55%"}, 200, function() { $('.product_rostest').css('display','none'); $('.product_global').css('display','none'); });
    $('.product_global').animate({top: "-55%"}, 200, function() { $('.product_rostest').css('display','none'); $('.product_global').css('display','none'); $('.product_inner').parent().css('overflow','visible'); });
});

$('.product_rostest_close').live('click', function() {
    $('.product_inner').css('overflow','visible');
    $('.product_rostest').animate({top: "-55%"}, 200, function() { $('.product_rostest').css('display','none'); $('.product_global').css('display','none'); });
    $('.product_global').animate({top: "-55%"}, 200, function() { $('.product_rostest').css('display','none'); $('.product_global').css('display','none'); $('.product_inner').parent().css('overflow','visible'); });
});

function fadeoutadded() {
    $('.add_to_cart_help').fadeOut(300);
}
function addToCartSmart1() {
    $('.add_to_cart_6770').addClass('added');
    $('.add_to_cart_6770').attr('onclick','location.href="/checkout/"');
    $('.add_to_cart_6770').find('.add_to_cart_help').fadeIn(300);
    $('.add_to_cart_2902').addClass('added');
    $('.add_to_cart_2902').attr('onclick','location.href="/checkout/"');
    $('.add_to_cart_2902').find('.add_to_cart_help').fadeIn(300);
    $('.add_to_cart_7019').addClass('added');
    $('.add_to_cart_7019').attr('onclick','location.href="/checkout/"');
    $('.add_to_cart_7019').find('.add_to_cart_help').fadeIn(300);
    $('.add_to_cart_4087').addClass('added');
    $('.add_to_cart_4087').attr('onclick','location.href="/checkout/"');
    $('.add_to_cart_4087').find('.add_to_cart_help').fadeIn(300);
    $('.add_to_cart_1806').addClass('added');
    $('.add_to_cart_1806').attr('onclick','location.href="/checkout/"');
    $('.add_to_cart_1806').find('.add_to_cart_help').fadeIn(300);
    $('.add_to_cart_5308').addClass('added');
    $('.add_to_cart_5308').attr('onclick','location.href="/checkout/"');
    $('.add_to_cart_5308').find('.add_to_cart_help').fadeIn(300);

    $.ajax({
        url: 'index.php?route=checkout/cart/add',
        type: 'post',
        data: 'product_id=3983&quantity=1',
        dataType: 'json',
        success: function(json) {
            if (json['success']) {
                $.ajax({
                    url: 'index.php?route=checkout/cart/add',
                    type: 'post',
                    data: 'product_id=4087&quantity=1',
                    dataType: 'json',
                    success: function(json) {
                        $.ajax({
                            url: 'index.php?route=checkout/cart/add',
                            type: 'post',
                            data: 'product_id=2655&quantity=1',
                            dataType: 'json',
                            success: function(json) {
                                $.ajax({
                                    url: 'index.php?route=checkout/cart/add',
                                    type: 'post',
                                    data: 'product_id=2641&quantity=1',
                                    dataType: 'json',
                                    success: function(json) {
                                        $.ajax({
                                            url: 'index.php?route=checkout/cart/add',
                                            type: 'post',
                                            data: 'product_id=3703&quantity=1',
                                            dataType: 'json',
                                            success: function(json) {
                                                $.ajax({
                                                    url: 'index.php?route=checkout/cart/add',
                                                    type: 'post',
                                                    data: 'product_id=5308&quantity=1',
                                                    dataType: 'json',
                                                    success: function(json) {
                                                        $.ajax({
                                                            url: 'index.php?route=checkout/cart/add',
                                                            type: 'post',
                                                            data: 'product_id=2270&quantity=1',
                                                            dataType: 'json',
                                                            success: function(json) {
                                                                if (json['success']) {
                                                                    yaCounter26740743.reachGoal('add_to_cart_yandex');
                                                                    $('#cart-total').html(json['total']);
                                                                    $('#header #cart .heading').addClass('heading_active');
                                                                    $('.product_popup .product_show_info').html(json['success']);
                                                                    $('.product_grey_bg').css('display','block');
                                                                    $('.product_popup').css('display','block');
                                                                    $('.rr_block').attr('data-product-id',json['products']);
                                                                    $('.rrblock_product').removeAttr('initialized');
                                                                    retailrocket.markup.render();
                                                                }
                                                            }
                                                        });
                                                    }
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            }
        }
    });
}
function addToCartSmart2() {
    $('.add_to_cart_6770').addClass('added');
    $('.add_to_cart_6770').attr('onclick','location.href="/checkout/"');
    $('.add_to_cart_6770').find('.add_to_cart_help').fadeIn(300);
    $('.add_to_cart_2902').addClass('added');
    $('.add_to_cart_2902').attr('onclick','location.href="/checkout/"');
    $('.add_to_cart_2902').find('.add_to_cart_help').fadeIn(300);
    $('.add_to_cart_7019').addClass('added');
    $('.add_to_cart_7019').attr('onclick','location.href="/checkout/"');
    $('.add_to_cart_7019').find('.add_to_cart_help').fadeIn(300);
    $('.add_to_cart_4087').addClass('added');
    $('.add_to_cart_4087').attr('onclick','location.href="/checkout/"');
    $('.add_to_cart_4087').find('.add_to_cart_help').fadeIn(300);
    $('.add_to_cart_1806').addClass('added');
    $('.add_to_cart_1806').attr('onclick','location.href="/checkout/"');
    $('.add_to_cart_1806').find('.add_to_cart_help').fadeIn(300);
    $('.add_to_cart_5308').addClass('added');
    $('.add_to_cart_5308').attr('onclick','location.href="/checkout/"');
    $('.add_to_cart_5308').find('.add_to_cart_help').fadeIn(300);

    $.ajax({
        url: 'index.php?route=checkout/cart/add',
        type: 'post',
        data: 'product_id=6770&quantity=1',
        dataType: 'json',
        success: function(json) {
            if (json['success']) {
                $.ajax({
                    url: 'index.php?route=checkout/cart/add',
                    type: 'post',
                    data: 'product_id=2902&quantity=1',
                    dataType: 'json',
                    success: function(json) {
                        $.ajax({
                            url: 'index.php?route=checkout/cart/add',
                            type: 'post',
                            data: 'product_id=7019&quantity=1',
                            dataType: 'json',
                            success: function(json) {
                                $.ajax({
                                    url: 'index.php?route=checkout/cart/add',
                                    type: 'post',
                                    data: 'product_id=4087&quantity=1',
                                    dataType: 'json',
                                    success: function(json) {
                                        $.ajax({
                                            url: 'index.php?route=checkout/cart/add',
                                            type: 'post',
                                            data: 'product_id=1806&quantity=1',
                                            dataType: 'json',
                                            success: function(json) {
                                                $.ajax({
                                                    url: 'index.php?route=checkout/cart/add',
                                                    type: 'post',
                                                    data: 'product_id=5308&quantity=1',
                                                    dataType: 'json',
                                                    success: function(json) {
                                                        if (json['success']) {
                                                            yaCounter26740743.reachGoal('add_to_cart_yandex');
                                                            $('#cart-total').html(json['total']);
                                                            $('#header #cart .heading').addClass('heading_active');
                                                            $('.product_popup .product_show_info').html(json['success']);
                                                            $('.product_grey_bg').css('display','block');
                                                            $('.product_popup').css('display','block');
                                                            $('.rr_block').attr('data-product-id',json['products']);
                                                            $('.rrblock_product').removeAttr('initialized');
                                                            retailrocket.markup.render();
                                                        }
                                                    }
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            }
        }
    });
}
function addToCartSmart3() {
    $('.add_to_cart_5308').addClass('added');
    $('.add_to_cart_5308').attr('onclick','location.href="/checkout/"');
    $('.add_to_cart_5308').find('.add_to_cart_help').fadeIn(300);
    $('.add_to_cart_2270').addClass('added');
    $('.add_to_cart_2270').attr('onclick','location.href="/checkout/"');
    $('.add_to_cart_2270').find('.add_to_cart_help').fadeIn(300);
    $('.add_to_cart_5826').addClass('added');
    $('.add_to_cart_5826').attr('onclick','location.href="/checkout/"');
    $('.add_to_cart_5826').find('.add_to_cart_help').fadeIn(300);

    $.ajax({
        url: 'index.php?route=checkout/cart/add',
        type: 'post',
        data: 'product_id=5308&quantity=1',
        dataType: 'json',
        success: function(json) {
            if (json['success']) {

                $.ajax({
                    url: 'index.php?route=checkout/cart/add',
                    type: 'post',
                    data: 'product_id=2270&quantity=1',
                    dataType: 'json',
                    success: function(json) {
                        $.ajax({
                            url: 'index.php?route=checkout/cart/add',
                            type: 'post',
                            data: 'product_id=5826&quantity=1',
                            dataType: 'json',
                            success: function(json) {
                                if (json['success']) {
                                    yaCounter26740743.reachGoal('add_to_cart_yandex');
                                    $('#cart-total').html(json['total']);
                                    $('#header #cart .heading').addClass('heading_active');
                                    $('.product_popup .product_show_info').html(json['success']);
                                    $('.product_grey_bg').css('display','block');
                                    $('.product_popup').css('display','block');
                                    $('.rr_block').attr('data-product-id',json['products']);
                                    $('.rrblock_product').removeAttr('initialized');
                                    retailrocket.markup.render();
                                }
                            }
                        });


                    }
                });


            }
        }
    });
}
function addToCartSmart4() {

    $('.add_to_cart_5308').addClass('added');
    $('.add_to_cart_5308').attr('onclick','location.href="/checkout/"');
    $('.add_to_cart_5308').find('.add_to_cart_help').fadeIn(300);
    $('.add_to_cart_2270').addClass('added');
    $('.add_to_cart_2270').attr('onclick','location.href="/checkout/"');
    $('.add_to_cart_2270').find('.add_to_cart_help').fadeIn(300);
    $('.add_to_cart_2543').addClass('added');
    $('.add_to_cart_2543').attr('onclick','location.href="/checkout/"');
    $('.add_to_cart_2543').find('.add_to_cart_help').fadeIn(300);

    $.ajax({
        url: 'index.php?route=checkout/cart/add',
        type: 'post',
        data: 'product_id=5308&quantity=1',
        dataType: 'json',
        success: function(json) {
            if (json['success']) {

                $.ajax({
                    url: 'index.php?route=checkout/cart/add',
                    type: 'post',
                    data: 'product_id=2270&quantity=1',
                    dataType: 'json',
                    success: function(json) {
                        $.ajax({
                            url: 'index.php?route=checkout/cart/add',
                            type: 'post',
                            data: 'product_id=2543&quantity=1',
                            dataType: 'json',
                            success: function(json) {
                                if (json['success']) {
                                    yaCounter26740743.reachGoal('add_to_cart_yandex');
                                    $('#cart-total').html(json['total']);
                                    $('#header #cart .heading').addClass('heading_active');
                                    $('.product_popup .product_show_info').html(json['success']);
                                    $('.product_grey_bg').css('display','block');
                                    $('.product_popup').css('display','block');
                                    $('.rr_block').attr('data-product-id',json['products']);
                                    $('.rrblock_product').removeAttr('initialized');
                                    retailrocket.markup.render();
                                }
                            }
                        });


                    }
                });


            }
        }
    });
}