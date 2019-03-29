function gerArrayFilters() {
    var filter = [];
    var data = $('#filterpro').serializeArray();
    data.forEach(function (item, index) {
        if(!filter[item['name']])
            filter[item['name']] = [];
        filter[item['name']].push(item['value']);
    });
    return filter;
}

function urlParamsGenerate(location_href){

    var filter = gerArrayFilters();

    var params = '';
    if(filter.page > 1)
        params += 'page-' + filter.page + '/';

    console.log(filter);

    var self = this;
    Object.keys(filter).forEach(function (column) {
        if(filter[column] && column != 'page' && column != 'category')
        {
            var value = filter[column];

            if($.isArray(filter[column])){
                value = '';
                $.each(filter[column], function(idx2, val2) {
                    if(val2)
                        value += val2 + '-or-';
                });
                if(value)
                    value = value.slice(0,-4);
            }

            if(value)
                params += column + '-' + value + '/';
        }
    });

    if($('.sort_select').val())
        params += $('.sort_select').val() + '/';

    if(params)
        params = params.slice(0,-1);

    var base_url = baseUrl();

    if(location_href)
        location.href = base_url + (params ? '/filters/' + params : '');
    else
        return params;
}

function filtersClear() {
    location.href = baseUrl();
}

function baseUrl() {
    var url = window.location.href;
    url =  url.split('/');
    return url[0] + '//' + url[2] + '/' + url[3] + '/' + url[4];
}

$(document).ready(function() {
    $('.sort_select').on('change', function () {
        urlParamsGenerate(true);
    });
});

function getCsrfToken() {
    return $('meta[name="csrf-token"]').attr('content');
}

function productFeaturesWishlist(self){
    var product_id   = $(self).attr('product_id');
    var product_url  = $(self).attr('product_url');
    var product_name = $(self).attr('product_name');

    $.ajax({
        url: '/product-features-wishlist/' + product_id,
        type: 'post',
        data: { _token: getCsrfToken() },
        dataType: 'json',
        success: function(data) {
            if(data)
            {
                productFeaturesWishlistCount();
                if($(self).hasClass('active'))
                    $(self).removeClass('active');
                else{
                    $(self).addClass('active');
                    Swal({
                        title: 'Закладки',
                        html: '<p class="text-swal2">Товар <a href="' + product_url + '">'
                        + product_name +
                        '</a> добавлен в <a href="/wishlist">закладки</a>!</p>'
                    });
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if(jqXHR.status == 401)
            {
                Swal({
                    title: 'Закладки',
                    html: '<p class="text-swal2">Необходимо войти в <a href="/login">Личный Кабинет</a> или <a href="/register">создать учетную запись</a>, '
                    +
                    'чтобы сохранить товар <a href="' + product_url + '">' + product_name + '</a> в свои <a href="/wishlist">закладки</a>!</p>'
                });
            }
        }
    });

}
function productFeaturesCompare(self){
    var product_id   = $(self).attr('product_id');
    var product_url  = $(self).attr('product_url');
    var product_name = $(self).attr('product_name');

    $.ajax({
        url: '/product-features-compare/' + product_id,
        type: 'post',
        data: { _token: getCsrfToken() },
        dataType: 'json',
        success: function(data) {
            if(data)
            {
                productFeaturesCompareCount();
                if($(self).hasClass('active'))
                    $(self).removeClass('active');
                else{
                    $(self).addClass('active');
                    Swal({
                        title: 'Сравнение товаров',
                        html: '<p class="text-swal2">Вы добавили <a href="' + product_url + '">' + product_name + '</a> в ваш <a href="/compare-products">список сравнения</a>!</p>'
                    });
                }
            }
        }
    });
}

function productFeaturesCompareCount(){
    $.ajax({
        url: '/product-features-compare-count',
        type: 'get',
        data: { _token: getCsrfToken() },
        dataType: 'json',
        success: function(data) {
            var count = parseInt(data);
            if(!count)
                $('.header_compare').addClass('non_active');
            else
                $('.header_compare').removeClass('non_active');
            $('.header_compare span').html(count);
        }
    });
}

function productFeaturesWishlistCount(){
    $.ajax({
        url: '/product-features-wishlist-count',
        type: 'get',
        data: { _token: getCsrfToken() },
        dataType: 'json',
        success: function(data) {
            var count = parseInt(data);
            if(!count)
                $('.header_wishlist').addClass('non_active');
            else
                $('.header_wishlist').removeClass('non_active');
            $('.header_wishlist span').html(count);
        }
    });
}


function productReviewSetLike(review_id, like, callback){
    $.ajax({
        url: '/product-review-set-like',
        type: 'post',
        dataType: 'json',
        data: {
            review_id: review_id,
            like:      like,
            _token:    getCsrfToken()
        },
        success: function (data) {
            callback(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status == 422) {
                swalErrors(jqXHR.responseJSON.errors, 'Ошибка 422');
            }
            callback(false);
        }
    });
}