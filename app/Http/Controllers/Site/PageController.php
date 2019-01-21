<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class PageController extends Controller
{

    public function deliveryPayment(){
        return view('site.page.delivery_payment');
    }

    public function guaranty(){
        return view('site.page.guaranty');
    }

    public function contact(){
        return view('site.page.contact');
    }

    public function publicoferta(){
        return view('site.page.publicoferta');
    }

    public function about(){
        return view('site.page.about');
    }




}