<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\AttributeGroup;
use App\Services\ServiceProductFeaturesCompare;
use App\Tools\Helpers;
use App\Tools\Seo;
use Redirect;

class ProductFeaturesCompareController extends Controller
{

    private $servicePFC;

    public function __construct(ServiceProductFeaturesCompare $servicePFC)
    {
        $this->servicePFC = $servicePFC;
    }

    public function addAndDelete($product_id){
        return $this->sendResponse(
            $this->servicePFC->addOrDelete($product_id)
        );
    }

    public function count(){
        return $this->sendResponse(
            $this->servicePFC->count()
        );
    }

    public function compareProducts(){

        $attributeGroups = AttributeGroup::with('attributes')->OrderBy('sort')->get();
        $productFeaturesCompareList = $this->servicePFC->productFeaturesCompareList();
        $seo = Seo::pageSeo('compare-products');

        return view(Helpers::isMobile() ? 'mobile.compare_products' : 'site.compare_products', [
            'attributeGroups' => $attributeGroups,
            'productFeaturesCompareList' => $productFeaturesCompareList,
            'seo' => $seo
        ]);
    }

    public function compareProductDelete(int $product_id){
        if($this->servicePFC->delete($product_id))
            return Redirect::back()->with('success', 'Ваш список сравнения изменен!');
        else
            return Redirect::back()->with('attention', 'Ошибка 404!');
    }

}