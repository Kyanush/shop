<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Services\ServiceCategory;
use App\Services\ServiceProduct;
use App\Services\ServiceYouWatchedProduct;
use App\Tools\Helpers;

class CatalogController extends Controller
{

    private $serviceProduct;

    public function __construct(ServiceProduct $serviceProduct)
    {

        $this->serviceProduct = $serviceProduct;
    }

    public function c($category){

        $category = Category::where('url', $category)->first();

        return view('mobile.c', [
            'category' => $category
        ]);

    }

    public function catalog($category = ''){

        $filters = Helpers::filtersProductsDecodeUrl($category);

        $filters['active'] = 1;

        $orderBy = Helpers::getSortedToFilter($filters);
        $column  = $orderBy['sorting_product']['column'];
        $order   = $orderBy['sorting_product']['order'];

        $priceMinMax = $this->serviceProduct->priceMinMax($filters);
        $productsAttributesFilters = $this->serviceProduct->productsAttributesFilters($filters);




        $products = Product::productInfoWith()
                            ->where(function ($query){
                                //скидки
                                if(strpos(url()->current(), '/specials') !== false)
                                {
                                    $query->WhereHas('specificPrice', function ($query) {
                                        $query->dateActive();
                                    });
                                }
                            })
                            ->filters($filters)
                            ->filtersAttributes($filters)
                            ->OrderBy($column, $order)
                            ->paginate(16)->onEachSide(1);

        $productsHitViewed = Product::productInfoWith()
                                    ->filters($category ? ['category' => $category] : [])
                                    ->OrderBy('viewed', 'DESC')
                                    ->limit(10)
                                    ->get();


        //Вы смотрели
        $serviceYouWatchedProduct = new ServiceYouWatchedProduct();
        $youWatchedProducts = $serviceYouWatchedProduct->listProducts();


        //категория
        $category = Category::where('url', $category)->first();

        $listCategoryFilterLinks = null;
        if($category)
        {
            $serviceCategory = new ServiceCategory();
            $listCategoryFilterLinks = $serviceCategory->listCategoryFilterLinks($category->id);
        }


        return view(Helpers::isMobile() ? 'mobile.catalog' : 'site.catalog', [
            'products' => $products,
            'youWatchedProducts' => $youWatchedProducts,
            'productsHitViewed' => $productsHitViewed,
            'filters' => $filters,
            'category' => $category,
            'listCategoryFilterLinks' => $listCategoryFilterLinks,
            'priceMinMax' => $priceMinMax,
            'productsAttributesFilters' => $productsAttributesFilters
        ]);
    }


}