$(".phone-mask").mask("+7(999) 999-9999");

$(document).ready(function() {



    $(isMobile() ? '.product-search-mobile' : '.product-search-desktop').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "/product-search",
                data: {
                    searchText: request.term,
                    maxResults: 10,
                   // _token: getCsrfToken()
                },
                dataType: "json",
                success: function (data) {

                    response($.map(data, function (item) {
                        return {
                            name:  item.name,
                            photo: item.photo,
                            url:   item.url
                        };
                    }));
                }
            })
        }}).data("ui-autocomplete")._renderItem = function (ul, item) {
        var inner_html =
            '<a class="list_item_container" href="' + item.url + '">' +
                '<div class="image"><img src="' + item.photo + '"/></div>' +
                '<div class="name">' + item.name + '</div>'
            '</div>';

        return $("<li></li>")
            .data("ui-autocomplete-item", item)
            .append(inner_html)
            .appendTo(ul);

    };





    /**************** меню *************************/
    $('#menu_categories').on('mouseenter', function(e) {
        if (window.innerWidth>=820)
        {
            $('.grey_bg').fadeIn(200);
            $('#menu').fadeIn(100,function(){});
            $('#menu_categories_selector').addClass('menu_categories_selector_active');
        }
    });

    $('#menu_categories_selector').click(function(){

        if(!$(this).hasClass('menu_categories_selector_active')){
            $('.grey_bg').fadeIn(200);
            $('#menu').fadeIn(100,function(){});
            $('#menu_categories_selector').addClass('menu_categories_selector_active');

        }else{
            $('.grey_bg').css('display','none');
            $('#menu').css('display','none');
            $('#menu_categories_selector').removeClass('menu_categories_selector_active');
        }
    });
    $('.grey_bg').on('mouseenter', function(e) {
        setTimeout(func, 50);
    });
    function func() {
        if ($('.grey_bg').is(":hover")) {
            $('.grey_bg').css('display','none');
            $('#menu').css('display','none');
            $('#menu_categories_selector').removeClass('menu_categories_selector_active');
        }
    }
    /**************** меню *************************/

    //карзина в шабке
    if(!isMobile()){
        $('#cart > .heading a').on('mouseenter', function() {
            if($('#cart').hasClass('active')){
                $('#cart').removeClass('active');
            }else{
                setTimeout(function () {
                    $('#cart').addClass('active');
                }.bind(this), 500);
                headerCartInfo();
            }
        });
    }else{
        $('#cart > .heading a').on('click', function() {
            if($('#cart').hasClass('active')){
                $('#cart').removeClass('active');
            }else{
                setTimeout(function () {
                    $('#cart').addClass('active');
                }.bind(this), 500);
                headerCartInfo();
            }
        });
    }

    $('#cart').on('mouseleave', function() {
        $(this).removeClass('active');
    });



    //Обратный звонок
    $('.callback_button').on('click', function() {
        es_show_temp_window($('#callback'), {
            vertical_align: 'top',
            padding: '0'
        });
        return false;
    });

    //Вопрос-ответ
    $('.write_review').on('click', function() {
        es_show_temp_window($('#write-review-popup'), {
            vertical_align: 'top',
            padding: '0',
            maxwidth: '640px'
        });
        return false;
    });

    //Написать отзыв
    $('.write_question').on('click', function() {
        es_show_temp_window($('#write-question-popup'), {
            vertical_align: 'top',
            padding: '0',
            maxwidth: '640px'
        });
        return false;
    });

    //Выход попап
    $('.review_popup_close, .question_popup_close, .callback_popup_close, .oneclick_popup_close').on('click', function() {
        es_close_temp_window();
    });

    //Купить в 1 клик
    $('#oneclick_button_send').on('click', function() {
        es_show_temp_window($('#one-click-order'), {
            vertical_align: 'top',
            padding: '0',
            maxwidth: '370px'
        });
        return false;
    });

    /** Фильтр **/
    $('#filterpro .option_name .podskazka, #filterpro .attribute_group_name .podskazka').on('click', function() {
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

    $('#filterpro .option_name').on('click', function() {
        if($(this).hasClass('hided')){
            $(this).removeClass('hided');
            $(this).next('.collapsible').css('display', 'block');
        }else{
            $(this).addClass('hided');
            $(this).next('.collapsible').css('display', 'none');
        }
    });

    $('.mobile_filter').on('click', function() {
        var cont_top = parseInt(window.pageYOffset ? window.pageYOffset : document.body.scrollTop);
        $('.background_adaptive_filter').css('display','block');
        $('#column-left').css('display','block');
        $('#column-left').css('left','-233px');
        $('#column-left').css('top',cont_top+'px');
        $('#column-left').css('display','block');
        $('#column-left').animate({left: "0"}, 300, function() {});
    });
    $('.background_adaptive_filter').on('click', function() {
        $('#column-left').css('display','none');
        $('.background_adaptive_filter').css('display','none');
    });
    $('.show_products_adaptive').on('click', function() {
        $('#column-left').css('display','none');
        $('.background_adaptive_filter').css('display','none');
    });
    /** Фильтр **/


    /** Сортировка каталог товара **/
    $('.product-filter .sort > div').on('click', function(e) {
        var sort = $(this).attr('sort');
        var order = $(this).attr('order');
        var selected_value = 0;
        if (sort=='viewed' && order=='DESC') { selected_value = 1; $('.product-filter .sort > div').removeClass('sort_active'); $(this).addClass('sort_active'); $(this).removeClass('sort_asc'); $(this).removeClass('sort_desc'); $(this).addClass('sort_asc');  $(this).attr('order','ASC'); }
        if (sort=='viewed' && order=='ASC') { selected_value = 2;  $('.product-filter .sort > div').removeClass('sort_active'); $(this).addClass('sort_active'); $(this).removeClass('sort_asc'); $(this).removeClass('sort_desc'); $(this).addClass('sort_desc'); $(this).attr('order','DESC'); }
        if (sort=='name' && order=='ASC') { selected_value = 3;    $('.product-filter .sort > div').removeClass('sort_active'); $(this).addClass('sort_active'); $(this).removeClass('sort_asc'); $(this).removeClass('sort_desc'); $(this).addClass('sort_desc'); $(this).attr('order','DESC'); }
        if (sort=='name' && order=='DESC') { selected_value = 4;   $('.product-filter .sort > div').removeClass('sort_active'); $(this).addClass('sort_active'); $(this).removeClass('sort_asc'); $(this).removeClass('sort_desc'); $(this).addClass('sort_asc');  $(this).attr('order','ASC'); }
        if (sort=='price' && order=='ASC') { selected_value = 5;   $('.product-filter .sort > div').removeClass('sort_active'); $(this).addClass('sort_active'); $(this).removeClass('sort_asc'); $(this).removeClass('sort_desc'); $(this).addClass('sort_desc'); $(this).attr('order','DESC'); }
        if (sort=='price' && order=='DESC') { selected_value = 6;  $('.product-filter .sort > div').removeClass('sort_active'); $(this).addClass('sort_active'); $(this).removeClass('sort_asc'); $(this).removeClass('sort_desc'); $(this).addClass('sort_asc');  $(this).attr('order','ASC'); }
        if (sort=='price' && order=='ASC') { selected_value = 5;   $('.product-filter .sort > div').removeClass('sort_active'); $(this).addClass('sort_active'); $(this).removeClass('sort_asc'); $(this).removeClass('sort_desc'); $(this).addClass('sort_desc'); $(this).attr('order','DESC'); }
        if (sort=='price' && order=='DESC') { selected_value = 6;  $('.product-filter .sort > div').removeClass('sort_active'); $(this).addClass('sort_active'); $(this).removeClass('sort_asc'); $(this).removeClass('sort_desc'); $(this).addClass('sort_asc');  $(this).attr('order','ASC'); }
        if (selected_value!=0)
        {
            $('.sort_select option:nth-child(' + selected_value + ')').prop('selected', true).attr('selected', 'true');
            $('.sort_select').change();
        }
    });





        var show_welcome_bottom = 1;
        var show_welcome_arrow = 0;
        var welcome_show_all_height = $('.category-info').height();
        if (parseInt(welcome_show_all_height)>150)
        {
            $('.category-info').height('150px');
            $('.category-info_show_all span').on('click', function() {
                if (show_welcome_bottom==1)
                {
                    show_welcome_bottom = 0;
                    if (show_welcome_arrow==0)
                    {
                        $(".category-info").animate({"padding-bottom": "80px", "height":welcome_show_all_height}, 200, function() {
                            show_welcome_bottom=1;
                        });
                        $('.category-info_show_all span').text('скрыть');
                        $('.category-info_show_all span').addClass('welcome_show_all_active');
                        show_welcome_arrow = 1;
                    }
                    else
                    {
                        $(".category-info").animate({"padding-bottom": "50px", "height":"150px"}, 200, function() {
                            show_welcome_bottom=1;
                        });
                        show_welcome_arrow = 0;
                        $('.category-info_show_all span').text('показать полностью');
                        $('.category-info_show_all span').removeClass('welcome_show_all_active');
                    }
                }
            });
        }
        else
        {
            $('.category-info_show_all').css('display','none');
        }



    //слайдер продук товара
    var mogno = 1;
    var element = '75';
    $('.image-additional-left').on('click', function() {
        if (mogno==1)
        {
            var topch = parseInt($('.image-additional-multi-inner').css('top'));
            if (topch<0)
            {
                mogno = 0;
                topch+=75;
                $('.image-additional-multi-inner').animate({top:topch}, 300, function(){mogno=1;});
            }
        }
        return false;
    });
    $('.image-additional-right').on('click', function() {
        if (mogno==1)
        {
            var topch = parseInt($('.image-additional-multi-inner').css('top'));
            if (topch>-element) {
                mogno = 0;
                topch-=75;
                $('.image-additional-multi-inner').animate({top:topch}, 300, function(){mogno=1;});
            }
        }
        return false;
    });



    $('.product_tabs_htabs a').click(function(e) {
        e.preventDefault();

        $('.product_tabs_htabs a').removeClass('product_tabs_tab_active');
        $(this).addClass('product_tabs_tab_active');

        $('.product_tabs_content > div').removeClass('active');
        $('#' + $(this).attr('tab') ).addClass('active');
    });

    //Перейти к описанию товара
    $('.go_to_description a').click(function(e) {
        $("a[tab=tab-attributes]").trigger('click');
        $('html, body').animate({scrollTop: $('#tab-attributes').offset().top - 70}, 1100);
    });

    //Характеристики товара
    $(window).scroll(function() {
        setScrollAttrs();
    });
    setScrollAttrs();
    $('.tab_attribute_group_left').on('click', function() {
        var tab_attribute_id = $(this).attr('tab_attribute_id');
        $('.tab_attribute_group_left').removeClass('tab_attribute_group_left_active');
        $(this).addClass('tab_attribute_group_left_active');
        $('html, body').animate({ scrollTop: $('.tab_attribute_group_right_top[tab_attribute_content="'+tab_attribute_id+'"]').offset().top }, 1100);
    });








    /******************** Написать отзыв - Оценка ******************/
    total_reiting = 0;
    id_arc = 55;
    var star_widht = total_reiting*24;
    $('#raiting_votes').width(star_widht);
    $('#raiting_info h5').append(total_reiting);
    he_voted = null;
    if(he_voted == null){
        $('#raiting').hover(function() {
                $('#raiting_votes, #raiting_hover').toggle();
            },
            function() {
                $('#raiting_votes, #raiting_hover').toggle();
            });
        $("#raiting").mousemove(function(e){
            var margin_doc = $("#raiting").offset();
            var widht_votes = e.pageX - margin_doc.left;
            if (widht_votes == 0) widht_votes = 1;
            user_votes = Math.ceil(widht_votes/24);
            $('#raiting_hover').width(user_votes*24);
        });
        $('#raiting').click(function() {
            if (user_votes!==undefined)
                $('input[name=rating]').val(user_votes);
            $('#raiting_votes').width((total_reiting + user_votes)*24);
        });
    }
    /******************** Написать отзыв ******************/





    /******************** footer menu ******************/
    $('.footer_column_header').on('click', function() {
        $(this).parent().find('ul').toggleClass('ul_opened');
    });




    /********************  menu header mobile ******************/
    $('.header_top_adaptive_menu').on('click', function() {
        $('.header_top_adaptive_menu_inner').css('display','block');
    });

    $('.header_top_adaptive_menu_closed').on('click', function() {
        $('.header_top_adaptive_menu_inner').css('display','none');
    });

    $('.header_top_adaptive_menu_go_close').on('click', function() {
        $('.header_top_adaptive_menu_inner').css('display','none');
    });





    /********************  searhc header mobile ******************/
    $('#search_adaptive_icon').on('click', function() {
        $('.search_adaptive_line').css('display','block');
        $('#cart').css('display','none');
    });
    $('.search-close2').on('click', function() {
        $('.search_adaptive_line').css('display','none');
        $('#cart').css('display','block');
    });










    /*  menu header catalog */
    $('#header #menu > ul > li > a').on('click', function() {
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
    $('#header #menu > ul > li > div > ul > li > a.level2_can_opened').on('click', function() {
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



    /******************** Лайк отзыва ******************/
    $('.as_yandex_review_plus').on('click', function () {
        var review_id = $(this).attr('review_id');
        var this_var = $(this);

        productReviewSetLike(review_id, 1, function (data) {
            if(data)
            {
                $('#as_yandex_review_' + review_id).find('.as_yandex_review_plus').find('.as_yandex_review_number').html(data['likes_count']);
                $('#as_yandex_review_' + review_id).find('.as_yandex_review_minus').find('.as_yandex_review_number').html(data['dis_likes_count']);
                this_var.addClass('as_yandex_review_plus_active');
                this_var.parent().find('.as_yandex_review_minus').removeClass('as_yandex_review_minus_active');
            }
        });
    });
    $('.as_yandex_review_minus').on('click', function () {
        var review_id = $(this).attr('review_id');
        var this_var = $(this);

        productReviewSetLike(review_id, 0, function (data) {
            if(data)
            {
                $('#as_yandex_review_' + review_id).find('.as_yandex_review_plus').find('.as_yandex_review_number').html(data['likes_count']);
                $('#as_yandex_review_' + review_id).find('.as_yandex_review_minus').find('.as_yandex_review_number').html(data['dis_likes_count']);
                this_var.addClass('as_yandex_review_minus_active');
                this_var.parent().find('.as_yandex_review_plus').removeClass('as_yandex_review_plus_active');
            }
        });
    });
    /******************** Лайк отзыва ******************/


});


function swalErrors(errors_array, title, type) {

    if(!title)
        title = 'Ошибка';

    if(!type)
        type = 'error';

    var errors_html = '';
    $.each(errors_array, function(index, value) {
        errors_html += value + '<br/>';
    });

    Swal({
        type:  type,
        title: title,
        html: errors_html
    });
}


/** Слайдер товара **/
if($('.product-images-main').length > 0)
{
    $('.product-images-main').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.product-images-nav'
    });
    $('.product-images-nav').slick({
        slidesToShow: window.screen.availWidth > 830 ? 4 : 3,
        slidesToScroll: 1,
        asNavFor: '.product-images-main',
        dots: false,
        centerMode: true,
        focusOnSelect: true
    });
}
/** Слайдер товара **/


//Характеристики товара
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


/** Готовые фильтры по категорию **/
function categoryFilterLinks(self) {
    if($(self).hasClass('also_category_add_open')){
        $('.invisible_li_box').css('display','block');
        $(self).find('span').text('Скрыть');
        $('.also_category_add_open').addClass('also_category_add_close');
        $('.also_category_add_open').removeClass('also_category_add_open');
    }else{
        $('.invisible_li_box').css('display','none');
        $(self).find('span').text('Ещё');
        $('.also_category_add_close').addClass('also_category_add_open');
        $('.also_category_add_close').removeClass('also_category_add_close');
    }
}

/***** Вид каталог товара  ******/
function display(view) {
    if (view == 'list') {
        $('#content .product-grid').addClass('product-list');
        $('#content .product-grid').removeClass('product-grid');

        $('#content .product-list > div').each(function(index, element) {
            html  = '<div class="right">';

            var price = $(element).find('.price').html();
            if (price != null) {
                html += '<div class="price">' + price  + '</div>';
            }
            html += '  <div class="stock">' + $(element).find('.stock').html() + '</div>';
            html += '  <div class="cart">' + $(element).find('.cart').html() + '</div>';
            html += '</div>';

            html += '<div class="left">';

            var image = $(element).find('.image').html();

            if (image != null) {
                html += '<div class="image">' + image + '</div>';
            }

            var product_features_top = $(element).find('.product_features_top').html();

            if (product_features_top != null) {
                html += '<div class="product_features_top">' + product_features_top + '</div>';
            }

            html += '  <div class="name">' + $(element).find('.name').html() + '</div>';
            var rating = $(element).find('.rating').html();

            if (rating != null) {
                html += '<div class="rating">' + rating + '</div>';
            }
            html += '  <div class="description">' + $(element).find('.description').html() + '</div>';

            html += '</div>';

            $(element).html(html);
        });

        $('.display').html('<div class="view_as_list active_view"></div> <div onclick="display(\'grid\');" class="view_as_grid"></div>');

        localStorage.setItem('display', 'list');
    } else {
        $('#content .product-list').addClass('product-grid');
        $('#content .product-list').removeClass('product-list');

        $('#content .product-grid > div').each(function(index, element) {
            html = '<div class="product_bg"></div><div class="product_inner">';

            var product_features_top = $(element).find('.product_features_top').html();

            if (product_features_top != null) {
                html += '<div class="product_features_top">' + product_features_top + '</div>';
            }

            var image = $(element).find('.image').html();

            if (image != null) {
                html += '<div class="image">' + image + '</div>';
            }

            html += '<div class="name">' + $(element).find('.name').html() + '</div>';
            html += '<div class="description">' + $(element).find('.description').html() + '</div>';

            var rating = $(element).find('.rating').html();

            if (rating != null) {
                html += '<div class="rating">' + rating + '</div>';
            }

            html += '<div class="product_bottom">';

            var price = $(element).find('.price').html();

            if (price != null) {
                html += '<div class="price">' + price  + '</div>';
            }
            html += '<div class="stock">' + $(element).find('.stock').html() + '</div>';

            html += '<div class="cart">' + $(element).find('.cart').html() + '</div>';
            html += '<div class="cl_b"></div>';

            html += '</div>';
            html += '</div>';

            $(element).html(html);
        });

        $('.display').html('<div onclick="display(\'list\');" class="view_as_list"></div> <div class="view_as_grid active_view"></div>');

        localStorage.setItem('display', 'grid');
    }
}






//Написать отзыв
function writeReview(self) {

    $.ajax({
        type: 'POST',
        url: '/write-review',
        data: getFormData(self),
        success: function(data) {
            if(data){
                es_close_temp_window();
                Swal({
                    title: 'Написать отзыв',
                    html: 'Ваш отзыв успешно оставлен'
                });
                clearFormData(self);
            }else{
                alert('Ошибка БД');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if(jqXHR.status == 422)
            {
                swalErrors(jqXHR.responseJSON.errors, 'Ошибка 422');
            }
        }
    });
}

//Написать отзыв
function writeQuestion(self)
{
    $.ajax({
        type: 'POST',
        url: '/write-question',
        data: getFormData(self),
        success: function(data) {
            if(data){
                es_close_temp_window();
                Swal({
                    title: 'Задать вопрос',
                    html: 'Ваш вопрос успешно задан'
                });
                clearFormData(self);
            }else{
                alert('Ошибка БД');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if(jqXHR.status == 422)
            {
                swalErrors(jqXHR.responseJSON.errors, 'Ошибка 422');
            }
        }
    });
}

function subscribe(self) {
    var formData = getFormData(self);
    $.ajax({
        type: 'POST',
        url: '/subscribe',
        data: formData,
        success: function(data) {
            if(data){
                var html  = formData['product_id'] ? 'Вы успешно подписались на уведомление о поступлении товара' : 'Вы успешно подписались на наши новости!';
                var title = formData['product_id'] ? 'Подписка на товары' : 'Подписка';
                    Swal({
                    title: title,
                    html: html
                });
            }else{
                Swal({
                    type: 'error',
                    title: 'Подписка',
                    html: 'Вы уже подписаны!'
                });
            }
            es_close_temp_window();
            clearFormData(self);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if(jqXHR.status == 422)
            {
                swalErrors(jqXHR.responseJSON.errors, 'Ошибка 422');
            }
        }
    });
}

var callbackWait = false;
function callback(self){
    if(!callbackWait)
    {
        callbackWait = true;
        $(self).find('.callback_button img').css('display', 'block');

        $.ajax({
            type: 'POST',
            url: '/callback',
            data: getFormData(self),
            success: function (data) {
                if (data) {
                    es_close_temp_window();
                    Swal({
                        title: 'Обратный звонок',
                        html: 'Заявка отправлена! В ближайшее время с Вами свяжется наш менеджер.'
                    });
                    clearFormData(self);
                }

                callbackWait = false;
                $(self).find('.callback_button img').css('display', 'none');

            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status == 422) {
                    swalErrors(jqXHR.responseJSON.errors, 'Ошибка 422');
                }

                callbackWait = false;
                $(self).find('.callback_button img').css('display', 'none');
            }
        });
    }
}



function headerCartInfo() {
    $.ajax({
        url: '/header-cart-info',
        type: 'get',
        data: {
            _token: getCsrfToken()
        },
        dataType: 'html',
        success: function(data) {
            $('#cart').find('.content').html(data);
        }
    });
}

var ocoWait = false;
function oneClickOrder(self) {

    if(!ocoWait)
    {
        ocoWait = true;
       // console.log($(self).find('.oneclick_button img').length);
        $(self).find('.oneclick_button img').css('display', 'block');

        $.ajax({
            type: 'POST',
            url: '/one-click-order',
            data: getFormData(self),
            success: function (data) {
                if (data) {
                    this.order_id = data['order_id'];
                    if (this.order_id) {
                        Swal({
                            type: 'success',
                            html: 'Номер заказа <a style="font-size: 20px;" href="/order-history/' + this.order_id + '">№:' + this.order_id + '</a>',
                            title: 'Ваш заказ успешно оформлен'
                        });
                    }
                } else {
                    alert('Ошибка БД');
                }
                es_close_temp_window();
                ocoWait = false;
                $(self).find('.oneclick_button img').css('display', 'none');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status == 422) {
                    swalErrors(jqXHR.responseJSON.errors, 'Ошибка 422');
                }
                ocoWait = false;
                $(self).find('.oneclick_button img').css('display', 'none');
            }
        });

    }

}

function addToCart(product_id) {
    product_id = parseInt(product_id);
    if(product_id > 0)
    {

        var result = false;
        $.ajax({
            async: false,
            url: '/cart-save',
            type: 'post',
            data: {
                product_id: product_id,
                _token: getCsrfToken()
            },
            dataType: 'json',
            success: function(data) {
                result = true;
            }
        });

        return result;
    }else{
        alert('Error');
    }
}

function addToCartInList(self){
    $(self).addClass('added');
    $(self).find('.add_to_cart_help').css('display', 'block');
    var product_id = $(self).attr('product_id');

    es_close_temp_window();

    setTimeout(function () {
        if(addToCart(product_id))
        {
            $(self).attr('href', '/checkout');

            setTimeout(function () {
                $(self).find('.add_to_cart_help').css('display', 'none');
            }.bind(this), 3000);

            headerCartTotal();
            cardSuccessPopup(product_id);
        }
    }.bind(this), 500);
}

function addToCartInDetail(self) {
    if($(self).attr('id') == 'button-cart')
    {
        var product_id = $(self).attr('product_id');
        if(addToCart(product_id))
        {
            $(self).attr('href', '/checkout');
            $(self).find('span').html('В корзине');
            $(self).attr('id', 'button-cart-incart');

            headerCartTotal();
            cardSuccessPopup(product_id);
            return false;
        }
    }

}

function cardSuccessPopup(product_id) {
    $('#card-success-popup').html('');

    $.ajax({
        url: '/card-success-popup/' + product_id,
        type: 'get',
        data: {
            _token: getCsrfToken()
        },
        dataType: 'html',
        success: function(data) {
            if(data)
            {
                $('#card-success-popup').html(data);
                es_show_temp_window($('#card-success-popup'), {
                    vertical_align: 'top',
                    padding: '0'
                });

                setTimeout(function () {

                    if(window.innerWidth < 700 && $('.items:not(.slick-slider)').length > 0)
                    {
                        $('.items').css('width', (window.innerWidth - 50) + 'px');
                    }

                    $('.items:not(.slick-slider)').slick({
                        adaptiveHeight: true,
                        dots: false,
                        arrows: true,
                        TouchMove: false,
                        draggable: true,
                        infinite: true,
                        autoplay: false,
                        variableWidth: true,
                        speed: 300,
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        swipeToSlide: true,
                        nextArrow: '<a href="javascript:void(0);" class="slick-next"></a>',
                        prevArrow: '<a href="javascript:void(0);" class="slick-prev"></a>',
                        /*
                        responsive: [
                            {
                                breakpoint: 400,
                                settings: {
                                    slidesToShow: 4,
                                    slidesToScroll: 4,
                                }
                            },
                            {
                                breakpoint: 400,
                                settings: {
                                    slidesToShow: 3,
                                    slidesToScroll: 3,
                                }
                            },
                            {
                                breakpoint: 400,
                                settings: {
                                    slidesToShow: 2,
                                    slidesToScroll: 2,
                                    arrows: false,
                                    centerMode: true
                                }
                            },
                            {
                                breakpoint: 400,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1,
                                    arrows: false,
                                    centerMode: true
                                }
                            },
                        ]*/
                    });
                }.bind(this), 250);

            }
        }
    });
}


function headerCartTotal(){
    $.ajax({
        url: '/cart-total',
        type: 'get',
        data: { _token: getCsrfToken() },
        dataType: 'json',
        success: function(data) {

            var quantity = parseInt(data['quantity']);
            var sum = data['sum'];

            $('.cart_counter').html(quantity);
            $('.cart_sum').html(sum);

            if(quantity == 0)
                $('#cart').find('.heading').removeClass('heading_active');
            else
                $('#cart').find('.heading').addClass('heading_active');
        }
    });
}

function headerCartProductDelete(self){
    var product_id = $(self).attr('product_id');
    if(cartProductDelete(product_id))
    {
        headerCartTotal();
        headerCartInfo();
    }
}

function cartProductDelete(product_id) {
    var result="";
    $.ajax({
        async: false,
        url: '/cart-delete/' + product_id,
        type: 'post',
        data: { _token: getCsrfToken() },
        dataType: 'json',
        success: function(data) {
            result = data;
        }
    });
    return result;
}

function getFormData(self) {
    var data_array = $(self).serializeArray();
    var data = {};
    data_array.forEach(function (item, index) {
        data[item['name']] = item['value'];
    });
    return data;
}

function clearFormData(self){
    $(self).find('input[type=text]').val('');
    $(self).find('input[type=email]').val('');
    $(self).find('input[type=password]').val('');
    $(self).find('textarea').val('');
}