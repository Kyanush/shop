<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\ServiceSlider;
use App\Models\Product;

class MainController extends Controller
{

    public function main(){


        $serviceSlider = new ServiceSlider();


        $productsRecommend = Product::productInfoWith()
            ->filtersAttributes(['rekomenduemoe_dlya_vas' => 'da'])
            ->limit(10)->inRandomOrder()->get();


        $productsDiscount = Product::productInfoWith()
                ->whereHas('specificPrice', function ($query){
                    $query->dateActive();
                })
                ->withCount('reviews')
                ->limit(10)
                ->inRandomOrder()
                ->get();


        $productsHit = Product::productInfoWith()
                ->filtersAttributes(['tipy_tovarov' => 'hit'])
                ->limit(10)
                ->inRandomOrder()
                ->get();


        $productsNew = Product::productInfoWith()
                    ->filtersAttributes(['tipy_tovarov' => 'new'])
                    ->limit(10)
                    ->inRandomOrder()
                    ->get();


        return view('site.main', [
            'listSlidersHomePage'          => $serviceSlider->listSlidersHomePage(),
            'productsRecommend'            => $productsRecommend,
            'productsDiscount'             => $productsDiscount,
            'productsHit'                  => $productsHit,
            'productsNew'                  => $productsNew
        ]);
    }

}