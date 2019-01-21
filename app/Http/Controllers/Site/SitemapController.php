<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class SitemapController extends Controller
{

    public function sitemap(){

        $products = Product::with('categories')->filters(['active' => 1])->get();
        $categories = Category::all();

        return response()->view('site.sitemap.sitemap', compact(['products', 'categories']))->header('Content-Type', 'text/xml');
    }

}