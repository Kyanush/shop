<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Tools\Helpers;

class PageController extends Controller
{

    public function deliveryPayment(){
        return view( Helpers::isMobile() ? 'mobile.page.delivery_payment' : 'site.page.delivery_payment');
    }

    public function guaranty(){
        return view(Helpers::isMobile() ? 'mobile.page.guaranty' : 'site.page.guaranty');
    }

    public function contact(){
        return view(Helpers::isMobile() ? 'mobile.page.contact' : 'site.page.contact');
    }

    public function about(){
        return view(Helpers::isMobile() ? 'mobile.page.about' : 'site.page.about');
    }

}