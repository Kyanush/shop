<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\AttributeGroup;
use App\Services\ServiceYouWatchedProduct;
use App\Tools\Helpers;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function cardSuccessPopup($product_id)
    {
        $product = Product::find($product_id);

        $products_interested = $product->productAccessories()->productInfoWith()->get();
        if(count($products_interested) == 0 or empty($products_interested))
            $products_interested = $product->groupProducts()->productInfoWith()->where('id', '<>', $product->id)->get();

        return view('includes.card_success_popup', [
            'product'  => $product,
            'products_interested' => $products_interested
        ]);
    }

    public function productDetail($category_url, $product_url, $product_tab = '')
    {

        $product = Product::productInfoWith()
                            ->with(['images' => function($query){
                                    $query->OrderBy('order', 'ASC');
                                },
                                'questionsAnswers' => function($query){
                                    $query->isActive();
                                },
                                'reviews' => function($query) use($product_tab){
                                    $query->with('isLike');
                                    $query->withCount(['likes', 'disLikes']);
                                    $query->isActive();

                                    if(empty($product_tab) and Helpers::isMobile())
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

        //Кол-во просмотров
        $product->increment('view_count');

        return view(Helpers::isMobile() ? 'mobile.product.index' : 'site.product_detail', [
            'product'  => $product,
            'product_tab' => $product_tab,
            'group_products' => $group_products,
            'products_interested' => $products_interested,
            'youWatchedProducts' => $youWatchedProducts,
            'category' => Category::where('url', $category_url)->first()
        ]);
    }

    public function productSearch(Request $request){

        $products = Product::filters(['name' => $request->input('searchText'), 'active' => 1])->limit(10)->get();
        $data = $products->map(function ($item) {
            return [
                'id'      => $item->id,
                'name'    => $item->name,
                'url'     => $item->detailUrlProduct(),
                'photo'   => $item->pathPhoto(true)
            ];
        });

        return  $this->sendResponse($data);
    }

    public function productImages($product_id){
        $product = Product::with('images')->findOrFail($product_id);

        $images = $product->images->map(function ($image) {
            return [ $image->imagePath(true) ];
        });

        return  $this->sendResponse([
            'images'  => $images,
            'youtube' => $product->youtube,
            'photo'   => $product->pathPhoto(true)
        ]);
    }
}