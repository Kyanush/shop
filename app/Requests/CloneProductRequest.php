<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class CloneProductRequest extends FormRequest
{

    public function rules()
    {
        $product_id = $this->input('clone_product.product_id');
        return [
            'clone_product.product_id' => 'exists:products,id',
            'clone_product.name'       => "max:255|required|unique:products,name,$product_id,id",
            'clone_product.sku'        => "max:100|required|unique:products,sku,$product_id,id"
        ];
    }

    public function attributes()
    {
        return [
            'clone_product.product_id' => "'Товар ID'",
            'clone_product.name'       => "'Название'",
            'clone_product.sku'        => "'SKU'"
        ];
    }

}