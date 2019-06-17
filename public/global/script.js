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

function urlParamsGenerate(){

    var filter = gerArrayFilters();

    var params = '';
    if(filter.page > 1)
        params += 'page-' + filter.page + '/';

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
    location.href = base_url + (params ? '/filters/' + params : '');
}

function filtersClear() {
    location.href = baseUrl();
}

function baseUrl() {
    var url = window.location.origin + window.location.pathname;;
    url =  url.split('/');
    var catalog = '/';

    var f = true;

    url.forEach(function (value, index) {
        if(index > 2 && f)
        {
            if(value == 'filters'){
                f = false;
            }else
                catalog += value + '/';
        }
    });

    catalog = catalog.substring(0, catalog.length - 1);

    return url[0] + '//' + url[2] + catalog;
}

$(document).ready(function() {
    $('.sort_select, #min_price, #max_price').on('change', function () {
        urlParamsGenerate();
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

function setCity(city_code){
    axios.post('/set-city/' + city_code, {
        _token: getCsrfToken()
    }).then(function (response) {
        console.log(response);
        location.href = '/';
    });
}

$(document).ready(function() {
    if($(".phone-mask").length > 0)
        $(".phone-mask").mask("+7(999) 999-9999");
});