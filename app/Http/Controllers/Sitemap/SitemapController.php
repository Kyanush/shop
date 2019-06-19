<?php

namespace App\Http\Controllers\Sitemap;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Product;
use App\Services\ServiceCity;

class SitemapController extends Controller
{

    public function sitemap(){
        $cities     = ServiceCity::listActiveSort();
        $siteUrl    = env('APP_URL');
        return response()->view('sitemap.sitemap', compact(['cities', 'siteUrl']))->header('Content-Type', 'text/xml');
    }

    public function pages(){
        $siteUrl    = env('APP_URL');
        return response()->view('sitemap.pages', compact(['siteUrl']))->header('Content-Type', 'text/xml');
    }

    public function city(){
        $city_code = \Route::currentRouteName();

        $city = City::where('code', $city_code)->first();
        $products   = Product::with('categories')->filters(['active' => 1])->get();
        $categories = Category::isActive()->get();
        $siteUrl    = env('APP_URL');
        return response()->view('sitemap.city', compact(['city', 'products', 'categories', 'siteUrl']))->header('Content-Type', 'text/xml');
    }

}