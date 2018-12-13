<?php

Route::get('/', function () {
    return view('welcome');
});


// Admin Interface
Route::group([/*'middleware' => 'auth',*/ 'prefix'     => 'admin', 'namespace'  => 'Admin'], function () {


    if (!request()->ajax()){
        Route::get('/{any}', 'AdminController@index')->where('any', '.*');

        Route::get('/', function () {
            return redirect('/admin/main');
        });

    }else{
        //Route::resource('category', 'Api\CategoryController');

       // Route::get('category/reorder', 'Api\CategoryController@reorder');


        Route::get('categories-list',          'Api\CategoryController@list');
        Route::get('category-reorder',         'Api\CategoryController@reorder');
        Route::get('category-view/{id}',       'Api\CategoryController@view')->where(['id' => '[0-9]+']);

        Route::post('category-create',         'Api\CategoryController@create');
        Route::post('category-update/{id}',    'Api\CategoryController@update')->where(['id' => '[0-9]+']);
        Route::post('category-delete/{id}',    'Api\CategoryController@delete')->where(['id' => '[0-9]+']);
        Route::post('reorder-save',            'Api\CategoryController@reorder_save');

        Route::get('attributes-list',          'Api\AttributeController@list');
        Route::post('attribute-save',          'Api\AttributeController@save');
        Route::get('attribute-view/{id}',      'Api\AttributeController@view')->where(['id' => '[0-9]+']);
        Route::post('attribute-delete/{id}',   'Api\AttributeController@delete')->where(['id' => '[0-9]+']);

        Route::get('attributes-sets-list ',      'Api\AttributeSetController@list');
        Route::post('attribute-set-save',        'Api\AttributeSetController@save');
        Route::get('attribute-set-view/{id}',    'Api\AttributeSetController@view')->where(['id' => '[0-9]+']);
        Route::post('attribute-set-delete/{id}', 'Api\AttributeSetController@delete')->where(['id' => '[0-9]+']);

        Route::get('products-list',              'Api\ProductController@list');
        Route::get('attribute-sets-more-info',   'Api\ProductController@AttributeSetsMoreInfo');
        Route::post('product-save',              'Api\ProductController@save');
        Route::get('product-view/{id}',          'Api\ProductController@view')->where(['id' => '[0-9]+']);
        Route::post('product-delete/{id}',       'Api\ProductController@delete')->where(['id' => '[0-9]+']);

        Route::get('group-products/{group_id}',  'Api\ProductController@groupProducts')->where(['group_id' => '[0-9]+']);

        Route::post('clone-product',              'Api\ProductController@cloneProduct');


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


        //Заказы
        Route::get('orders-list',         'Api\OrderController@list');
        Route::get('order/{id}',          'Api\OrderController@view')->where(['id' => '[0-9]+']);
        Route::get('order/users',         'Api\OrderController@users');
        Route::post('order-save',         'Api\OrderController@orderSave');

        //компания
        Route::get('addresses-list',        'Api\AddressController@list');
    }


    /*
    CRUD::resource('categories', 'CategoryController');
    CRUD::resource('currencies', 'CurrencyCrudController');
    CRUD::resource('carriers', 'CarrierCrudController');
    CRUD::resource('attributes', 'AttributeCrudController');
    CRUD::resource('attributes-sets', 'AttributeSetCrudController');
    CRUD::resource('products', 'ProductCrudController');

    CRUD::resource('orders', 'OrderCrudController');
    CRUD::resource('order-statuses', 'OrderStatusCrudController');
    CRUD::resource('clients', 'ClientCrudController');
    CRUD::resource('users', 'UserCrudController');
    CRUD::resource('cart-rules', 'CartRuleCrudController');
    CRUD::resource('specific-prices', 'SpecificPriceCrudController');
    CRUD::resource('notification-templates', 'NotificationTemplateCrudController');

    // Clone Products
    Route::post('products/clone', ['as' => 'clone.product', 'uses' => 'ProductCrudController@cloneProduct']);

    // Update Order Status
    Route::post('orders/update-status', ['as' => 'updateOrderStatus', 'uses' => 'OrderCrudController@updateStatus']);
    */
});

/*
// Ajax
Route::group(['middleware' => 'admin',
    'prefix' => 'ajax',
    'namespace' => 'Admin'
], function() {
    // Get attributes by set id
    Route::post('attribute-sets/list-attributes', ['as' => 'getAttrBySetId', 'uses' => 'AttributeSetCrudController@ajaxGetAttributesBySetId']);

    // Product images upload routes
    Route::post('product/image/upload', ['as' => 'uploadProductImages', 'uses' => 'ProductCrudController@ajaxUploadProductImages']);
    Route::post('product/image/reorder', ['as' => 'reorderProductImages', 'uses' => 'ProductCrudController@ajaxReorderProductImages']);
    Route::post('product/image/delete', ['as' => 'deleteProductImage', 'uses' => 'ProductCrudController@ajaxDeleteProductImage']);

    // Get group products by group id
    Route::post('product-group/list/products', ['as' => 'getGroupProducts', 'uses' => 'ProductGroupController@getGroupProducts']);
    Route::post('product-group/list/ungrouped-products', ['as' => 'getUngroupedProducts', 'uses' => 'ProductGroupController@getUngroupedProducts']);
    Route::post('product-group/add/product', ['as' => 'addProductToGroup', 'uses' => 'ProductGroupController@addProductToGroup']);
    Route::post('product-group/remove/product', ['as' => 'removeProductFromGroup', 'uses' => 'ProductGroupController@removeProductFromGroup']);

    // Client address
    Route::post('client/list/addresses', ['as' => 'getClientAddresses', 'uses' => 'ClientAddressController@getClientAddresses']);
    Route::post('client/add/address', ['as' => 'addClientAddress', 'uses' => 'ClientAddressController@addClientAddress']);
    Route::post('client/delete/address', ['as' => 'deleteClientAddress', 'uses' => 'ClientAddressController@deleteClientAddress']);

    // Client company
    Route::post('client/list/companies', ['as' => 'getClientCompanies', 'uses' => 'ClientCompanyController@getClientCompanies']);
    Route::post('client/add/company', ['as' => 'addClientCompany', 'uses' => 'ClientCompanyController@addClientCompany']);
    Route::post('client/delete/company', ['as' => 'deleteClientCompany', 'uses' => 'ClientCompanyController@deleteClientCompany']);

    // Notification templates
    Route::post('notification-templates/list-model-variables', ['as' => 'listModelVars', 'uses' => 'NotificationTemplateCrudController@listModelVars']);
});
*/

Auth::routes();