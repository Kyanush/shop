<?php
namespace App\Services;

use App\Models\ProductFeaturesCompare;
use App\Tools\Helpers;

class ServiceProductFeaturesCompare
{

    private $model;
    public function __construct()
    {
        $this->model = new ProductFeaturesCompare();
    }

    public function add(int $product_id)
    {
        $product = $this->model::findOrNew($product_id);
        $product->fill([
            'product_id'   => $product_id,
            'visit_number' => Helpers::getVisitNumber()
        ]);
        return $product->save() ? true : false;
    }

    public function delete(int $product_id)
    {
        return $this->model::searchVisitNumber()->where('product_id', $product_id)->delete();
    }

    public function addOrDelete($product_id)
    {
        $compareProduct = $this->model::searchVisitNumber()->where('product_id', $product_id)->first();
        if($compareProduct){
            return $this->delete($product_id);
        }else{
            return $this->add($product_id);
        }
    }

    public function count(){
        return $this->model::searchVisitNumber()->count();
    }

    public function productFeaturesCompareList(){

        return $this->model::with(['product' => function($query){
                $query->productInfoWith();
        }])
        ->searchVisitNumber()
        ->get();

    }
}