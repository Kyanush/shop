<?php
namespace App\Services;

use App\Models\ProductFeaturesWishlist;
use Auth;

class ServiceProductFeaturesWishlist
{

    private $model;
    public function __construct()
    {
        $this->model = new ProductFeaturesWishlist();
    }

    public function delete(int $product_id){
        return $this->model::isAuthUser()->where('product_id', $product_id)->delete();
    }

    public function add(int $product_id)
    {
        $product = $this->model::findOrNew($product_id);
        $product->fill([
            'user_id'    => Auth::user()->id,
            'product_id' => $product_id

        ]);
        return $product->save() ? true : false;
    }

    public function addOrDelete($product_id)
    {
        $compareProduct = $this->model::isAuthUser()->where('product_id', $product_id)->first();
        if($compareProduct){
            return $this->delete($product_id);
        }else{
            return $this->add($product_id);
        }
    }

    public function count(){
        return $this->model::isAuthUser()->count();
    }

    public function list(){
        return $this->model::with(['product' => function($query){
                                $query->with(['specificPrice' => function($query){
                                    $query->dateActive();
                                }]);
                            }])
                            ->isAuthUser()
                            ->get();
    }

}