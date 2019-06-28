<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Services\ServiceCategory;
use App\Services\ServiceCity;
use App\Services\ServiceProduct;
use App\Services\ServiceYouWatchedProduct;
use App\Tools\Helpers;
use App\Tools\Seo;

class CatalogController extends Controller
{

    private $serviceProduct;

    public function __construct(ServiceProduct $serviceProduct)
    {

        $this->serviceProduct = $serviceProduct;
    }

    public function c($cCategory){

        //категория
        $category = Category::where('url', $cCategory)->first();
        //город
        $currentCity = ServiceCity::getCurrentCity();
        //seo
        $seo = Seo::catalog($category);

        return view('mobile.c', [
            'category'    => $category,
            'currentCity' => $currentCity,
            'seo'         => $seo
        ]);

    }

    public function catalogCity($city, $category){
        return $this->catalogMain($city, $category);
    }

    public function catalog($category){
        return $this->catalogMain('almaty', $category);
    }

    public function catalogMain($city, $category_code){
        //категория
        $category = Category::isActive()->where('url', $category_code)->firstOrFail();

        $filters = Helpers::filtersProductsDecodeUrl($category_code);

        $filters['active'] = 1;

        $orderBy = Helpers::getSortedToFilter($filters);
        $column  = $orderBy['sorting_product']['column'];
        $order   = $orderBy['sorting_product']['order'];

        $priceMinMax = $this->serviceProduct->priceMinMax(['category' => $filters['category'], 'active' => 1]);
        $productsAttributesFilters = $this->serviceProduct->productsAttributesFilters($filters);




        $products = Product::productInfoWith()
            ->where(function ($query){
                //скидки
                /*
                if(strpos(url()->current(), '/specials') !== false)
                {
                    $query->WhereHas('specificPrice', function ($query) {
                        $query->dateActive();
                    });
                }*/
            })
            ->filters($filters)
            ->filtersAttributes($filters)
            ->OrderBy($column, $order)
            ->paginate(16)->onEachSide(1);

        $productsHitViewed = Product::productInfoWith()
            ->filters($category_code ? ['category' => $category_code] : [])
            ->OrderBy('viewed', 'DESC')
            ->limit(10)
            ->get();


        //Вы смотрели
        $serviceYouWatchedProduct = new ServiceYouWatchedProduct();
        $youWatchedProducts = $serviceYouWatchedProduct->listProducts();

        //seo
        $seo = Seo::catalog($category);
        if(!$seo)
            return abort(404);

        //город
        $currentCity = ServiceCity::getCurrentCity();
        if(!$currentCity)
            return abort(404);

        //загловок
        $title = $category->name  . ' в ' . $currentCity->name;

        //Хлебная крошка
        $breadcrumbs = ServiceCategory::breadcrumbCategories($category->parent_id, $title);

        return view(Helpers::isMobile() ? 'mobile.catalog' : 'site.catalog', [
            'products' => $products,
            'youWatchedProducts' => $youWatchedProducts,
            'productsHitViewed' => $productsHitViewed,
            'filters' => $filters,
            'category' => $category,
            'priceMinMax' => $priceMinMax,
            'productsAttributesFilters' => $productsAttributesFilters,
            'seo' => $seo,
            'currentCity' => $currentCity,
            'breadcrumbs' => $breadcrumbs,
            'title' => $title
        ]);
    }


}