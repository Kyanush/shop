<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\AttributeGroup;
use App\Services\ServiceYouWatchedProduct;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function productDetail($category_url, $product_url, $product_tab = '')
    {

        $product = Product::productInfoWith()
                            ->with(['images' => function($query){
                                    $query->OrderBy('order', 'ASC');
                                },
                                'questionsAnswers' => function($query){
                                    $query->isActive();
                                },
                                'reviews' => function($query) use ($product_tab){
                                    $query->with('isLike');
                                    $query->withCount(['likes', 'disLikes']);
                                    $query->isActive();

                                    if(empty($product_tab))
                                        $query->limit(2);
                                }
                            ])
                            ->where('url', $product_url)
                            ->first();
        $group_products = $product->groupProducts()->productInfoWith()->where('id', '<>', $product->id)->get();

        $products_interested = $product->productAccessories()->productInfoWith()->get();

        //Вы смотрели
        $serviceYouWatchedProduct = new ServiceYouWatchedProduct();
        $serviceYouWatchedProduct->youWatchedProduct($product->id);
        $youWatchedProducts = $serviceYouWatchedProduct->listProducts($product->id);


        return view('mobile.product.index', [
            'product'  => $product,
            'product_tab' => $product_tab,
            'group_products' => $group_products,
            'products_interested' => $products_interested,
            'youWatchedProducts' => $youWatchedProducts,
            'category' => Category::where('url', $category_url)->first()
        ]);
    }


}