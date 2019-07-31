<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\ServiceSlider;
use App\Models\Product;
use App\Tools\Helpers;
use App\Tools\Seo;


class MainController extends Controller
{

    public function main(){


        $productsRecommend = Product::productInfoWith()
            ->filtersAttributes(['rekomenduemoe_dlya_vas' => 'da'])
            ->limit(10)
            ->where('stock', '>', 0)
            //->OrderBy('id', 'DESC')
            ->inRandomOrder()
            ->get();


        $productsDiscount = Product::productInfoWith()
                ->whereHas('specificPrice', function ($query){
                    $query->dateActive();
                })
                ->withCount('reviews')
                ->limit(10)
                ->where('stock', '>', 0)
                //->OrderBy('id', 'DESC')
                ->inRandomOrder()
                ->get();


        $productsHit = Product::productInfoWith()
                ->filtersAttributes(['tipy_tovarov' => 'hit'])
                ->limit(10)
                ->where('stock', '>', 0)
                //->OrderBy('id', 'DESC')
                ->inRandomOrder()
                ->get();


        $productsNew = Product::productInfoWith()
                    ->filtersAttributes(['tipy_tovarov' => 'new'])
                    ->limit(10)
                    ->where('stock', '>', 0)
                    //->OrderBy('id', 'DESC')
                    ->inRandomOrder()
                    ->get();

        $seo = Seo::main();

        return view(Helpers::isMobile() ? 'mobile.main' : 'site.main',
            [
                'listSlidersHomePage'          => ServiceSlider::listSlidersHomePage(),
                'productsRecommend'            => $productsRecommend,
                'productsDiscount'             => $productsDiscount,
                'productsHit'                  => $productsHit,
                'productsNew'                  => $productsNew,
                'seo'                          => $seo
            ]);
    }

}