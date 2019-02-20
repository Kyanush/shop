<?php

//загрузить файл
Route::post('ckeditor-upload-image',   'UploadImageController@CkeditorUploadImage');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::group(['namespace'  => 'Site'], function () {

    Route::get('/',          'MainController@main');
    Route::post('product-features-compare/{product_id}', 'ProductFeaturesCompareController@addAndDelete')->where(['product_id' => '[0-9]+']);

    //Корзина
    Route::post('cart-save',                'CartController@cartSave');
    Route::post('cart-delete/{product_id}', 'CartController@cartDelete')->where(['product_id' => '[0-9]+']);
    Route::get('cart-total/{carrier_id?}', 'CartController@cartTotal')->where(['carrier_id' => '[0-9]+']);;
    Route::get('header-cart-info',          'CartController@header_cart_info');

    Route::get('checkout',   'CartController@checkout');
    Route::post('checkout',  'CartController@saveCheckout');
    Route::post('one-click-order',  'CartController@oneClickOrder');


    Route::post('list-cart',                'CartController@listCart');

    Route::post('list-carriers',            'CarrierController@listCarriers');
    Route::post('list-payments',            'PaymentController@listPayments');


    Route::get('product-search', 'ProductController@productSearch');


    Route::get('card-success-popup/{product_id}', 'ProductController@cardSuccessPopup')->where(['product_id' => '[0-9]+']);

    Route::get('product-features-compare-count',   'ProductFeaturesCompareController@count');
    Route::get('product-features-wishlist-count',  'ProductFeaturesWishlistController@count');

    Route::get('compare-products',                      'ProductFeaturesCompareController@compareProducts');
    Route::get('compare-product-delete/{product_id}',   'ProductFeaturesCompareController@compareProductDelete')->where(['product_id' => '[0-9]+']);

    Route::post('callback',  'CallbackController@callback');
    Route::post('contact',  'CallbackController@contact');



    Route::post('subscribe', 'SubscribeController@subscribe');


    $params = '';
    for ($i = 0; $i <= 100; $i++){
        $params .= "/{param$i?}";
    }

    Route::get('catalog/{category?}' . $params, 'CatalogController@catalog')->where(['category']);
    Route::get('specials/{category?}' . $params, 'CatalogController@catalog')->where(['category']);



    Route::get('product/{category_url}/{product_url}/{product_tab?}',  'ProductController@productDetail')->where(['category_url'])
                                                                                                         ->where(['product_url'])
                                                                                                         ->where(['product_tab']);

    Route::post('product-review-set-like', 'ReviewController@setLike');

    Route::post('write-review',            'ReviewController@writeReview');
    Route::post('write-question',          'QuestionAnswerController@writeQuestion');


    Route::get('delivery-payment',          'PageController@deliveryPayment');
    Route::get('guaranty',          'PageController@guaranty');
    Route::get('contact',          'PageController@contact');
    Route::get('about',          'PageController@about');


    //sitemap
    Route::get('sitemap.xml', 'SitemapController@sitemap');
});

Route::group(['middleware' => 'auth', 'namespace'  => 'Site'], function () {

    Route::post('product-features-wishlist/{product_id}', 'ProductFeaturesWishlistController@addAndDelete')->where(['product_id' => '[0-9]+']);

    Route::get('my-account',    'UserController@myAccount');
    Route::get('account-edit',  'UserController@accountEdit');
    Route::post('account-edit', 'UserController@accountEditSave');

    Route::get('change-password',  'UserController@changePassword');
    Route::post('change-password', 'UserController@changePasswordSave');

    Route::get('order-history',             'OrderController@orderHistory');
    Route::get('order-history/{order_id}',  'OrderController@orderHistoryDetail')->where(['order_id' => '[0-9]+']);;




    Route::get('wishlist',               'ProductFeaturesWishlistController@wishlist');
    Route::get('wishlist-delete/{product_id}',  'ProductFeaturesWishlistController@delete')->where(['product_id' => '[0-9]+']);

});












// Admin Interface
Route::group(['middleware' => ['role:admin'], 'prefix'     => 'admin', 'namespace'  => 'Admin'], function () {


    if (!request()->ajax()){
        Route::get('/{any}', 'AdminController@index')->where('any', '.*');

        Route::get('/', function () {
            return redirect('/admin/main');
        });

    }else{


        Route::get('categories-list',          'Api\CategoryController@list');
        Route::get('category-view/{id}',       'Api\CategoryController@view')->where(['id' => '[0-9]+']);
        Route::get('catalogs-tree/{type}',     'Api\CategoryController@catalogsTree')->where(['type' => '[0-9]+']);

        Route::post('category-save',          'Api\CategoryController@save');
        Route::post('category-delete/{id}',    'Api\CategoryController@delete')->where(['id' => '[0-9]+']);
        Route::post('reorder-save',            'Api\CategoryController@reorderSave');

        Route::get('attributes-list',          'Api\AttributeController@list');
        Route::post('attribute-save',          'Api\AttributeController@save');
        Route::get('attribute-view/{id}',      'Api\AttributeController@view')->where(['id' => '[0-9]+']);
        Route::post('attribute-delete/{id}',   'Api\AttributeController@delete')->where(['id' => '[0-9]+']);

        Route::get('attributes-sets-list ',      'Api\AttributeSetController@list');
        Route::post('attribute-set-save',        'Api\AttributeSetController@save');
        Route::get('attribute-set-view/{id}',    'Api\AttributeSetController@view')->where(['id' => '[0-9]+']);
        Route::post('attribute-set-delete/{id}', 'Api\AttributeSetController@delete')->where(['id' => '[0-9]+']);

        Route::any('products-list',              'Api\ProductController@list');
        Route::get('attribute-sets-more-info',   'Api\ProductController@AttributeSetsMoreInfo');
        Route::post('product-save',              'Api\ProductController@save');
        Route::get('product-view/{id}',          'Api\ProductController@view')->where(['id' => '[0-9]+']);
        Route::post('product-delete/{id}',       'Api\ProductController@delete')->where(['id' => '[0-9]+']);
        Route::post('product-price-min-max',     'Api\ProductController@priceMinMax');
        Route::post('products-attributes-filters',   'Api\ProductController@productsAttributesFilters');
        Route::get('group-products/{group_id}',  'Api\ProductController@groupProducts')->where(['group_id' => '[0-9]+']);
        Route::post('clone-product',             'Api\ProductController@cloneProduct');
        Route::get('all-products-select2',       'Api\ProductController@allProductsSelect2');


        //отзывы
        Route::get('reviews-list',                'Api\ReviewController@list');
        Route::post('review-delete/{review_id}',  'Api\ReviewController@delete')->where(['review_id' => '[0-9]+']);
        Route::post('review-save',                'Api\ReviewController@save');


        //Вопросы-ответы
        Route::get('questions-answers-list',               'Api\QuestionAnswerController@list');
        Route::post('question-answer-delete/{review_id}',  'Api\QuestionAnswerController@delete')->where(['review_id' => '[0-9]+']);
        Route::post('question-answer-save',                'Api\QuestionAnswerController@save');


        //Пользователи
        Route::get('users-list',        'Api\UserController@list');
        Route::get('user-view/{id}',    'Api\UserController@view')->where(['id' => '[0-9]+']);
        Route::post('user-save',        'Api\UserController@save');
        Route::post('user-delete/{id}', 'Api\UserController@delete')->where(['id' => '[0-9]+']);

        //Роли
        Route::get('roles-list',        'Api\RoleController@list');

        //Курьеры
        Route::get('carriers-list',              'Api\CarrierController@list');
        Route::post('carrier-save',              'Api\CarrierController@save');
        Route::get('carrier-view/{id}',          'Api\CarrierController@view')->where(['id' => '[0-9]+']);
        Route::post('carrier-delete/{id}',       'Api\CarrierController@delete')->where(['id' => '[0-9]+']);

        //Слайдер
        Route::get('sliders-list',              'Api\SliderController@list');
        Route::post('slider-save',              'Api\SliderController@save');
        Route::get('slider-view/{id}',          'Api\SliderController@view')->where(['id' => '[0-9]+']);
        Route::post('slider-delete/{id}',       'Api\SliderController@delete')->where(['id' => '[0-9]+']);


        //тип оплаты
        Route::get('payments-list',              'Api\PaymentController@list');
        Route::post('payment-save',              'Api\PaymentController@save');
        Route::get('payment-view/{id}',          'Api\PaymentController@view')->where(['id' => '[0-9]+']);
        Route::post('payment-delete/{id}',       'Api\PaymentController@delete')->where(['id' => '[0-9]+']);

        //Статусы заказов
        Route::get('order-statuses-list',             'Api\OrderStatusController@list');
        Route::post('order-status-save',              'Api\OrderStatusController@save');
        Route::get('order-status-view/{id}',          'Api\OrderStatusController@view')->where(['id' => '[0-9]+']);
        Route::post('order-status-delete/{id}',       'Api\OrderStatusController@delete')->where(['id' => '[0-9]+']);


        //Скидки
        Route::get('specific-prices-list',             'Api\SpecificPriceController@list');
        Route::post('specific-price-delete/{id}',      'Api\SpecificPriceController@delete')->where(['id' => '[0-9]+']);


        //Обратный звонок
        Route::get('callbacks-list',             'Api\CallbackController@list');
        Route::post('callback-delete/{id}',      'Api\CallbackController@delete')->where(['id' => '[0-9]+']);


        //Заказы
        Route::get('orders-list',                'Api\OrderController@list');
        Route::get('order/{id}',                 'Api\OrderController@view')->where(['id' => '[0-9]+']);
        Route::get('order/users',                'Api\OrderController@users');
        Route::post('order-save',                'Api\OrderController@orderSave');
        Route::get('calendar-orders',            'Api\OrderController@calendarOrders');
        Route::post('order-delete/{order_id}',   'Api\OrderController@orderDelete')->where(['order_id' => '[0-9]+']);


        //компания
        Route::get('addresses-list',        'Api\AddressController@list');

        //Группа атрибутов
        Route::get('attribute-groups-list',        'Api\AttributeGroupController@list');
    }

});








Auth::routes();