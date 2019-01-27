<?php

namespace App\Http\Controllers\Admin\Api;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Product;
use App\Models\AttributeSet;

use App\Models\SpecificPrice;
use App\Requests\CloneProductRequest;
use App\Requests\SaveProductRequest;
use App\Services\ServiceAttributeProductValue;
use App\Services\ServiceProduct;
use App\Services\ServiceCategory;
use App\Tools\Helpers;
use App\Tools\UploadableTrait;
use Illuminate\Http\Request;
use DB;
use File;

class ProductController extends AdminController
{
    use UploadableTrait;
    private $serviceAttrProductVal, $serviceProduct, $serviceCategory;

    public function __construct(ServiceAttributeProductValue $serviceAttrProductVal,
                                ServiceProduct $serviceProduct,
                                ServiceCategory $serviceCategory)
    {
        parent::__construct();
        $this->serviceAttrProductVal = $serviceAttrProductVal;
        $this->serviceProduct = $serviceProduct;
        $this->serviceCategory = $serviceCategory;
    }


    public function allProductsSelect2(){
        $products = Product::all();

        $data = $products->map(function ($item) {
            return [
                'id'   => $item->id,
                'text' => $item->name
            ];
        });

        return $this->sendResponse($data);
    }

    public function list(Request $request)
    {

        $list =  Product::with([
                'categories' => function($query){
                    $query->select([DB::raw('t_categories.id'), DB::raw('t_categories.name')]);
                },
                'specificPrice' => function($query){
                    $query->dateActive();
                }
            ])
            ->filters($request->all())
            ->filtersAttributes($request->all())
            ->OrderBy('id', 'DESC')
            ->paginate($request->input('perPage', 10));

        foreach ($list as $key => $item)
        {
            if($item->specificPrice)
            {
                $list[$key]->price_discount = Helpers::priceFormat($item->getReducedPrice());
            }

            $list[$key]->path_photo = $item->pathPhoto(true);
            $list[$key]->format_price = Helpers::priceFormat($item->price);
        }

        return  $this->sendResponse($list);
    }

    public function AttributeSetsMoreInfo(){
        $list =  AttributeSet::with('attributes.values')->get();
        return  $this->sendResponse($list);
    }

    public function save(SaveProductRequest $req)
    {

        $request = $req->all();

        $reqProduct = $request['product'];

        $product = Product::findOrNew($reqProduct['id']);
        $product->fill($reqProduct);

        $old_attribute_set_id = $product->attribute_set_id;

        if($product->save())
        {
            //категория
            $product->categories()->sync($request['categories']);

            //Конкретная цена
            if(!empty($request['specific_price']['reduction']))
            {
                $SpecificPrice = SpecificPrice::firstOrNew(['product_id' => $product->id]);
                $SpecificPrice->fill($request['specific_price']);
                $SpecificPrice->save();
            }

            //Атрибуты
            $this->serviceProduct->productAttributesSave(
                $product->id,
                $request['attributes'],
                $old_attribute_set_id == $reqProduct['attribute_set_id'] ? false : true
            );

            //Картинки
            $this->serviceProduct->productImagesSave($request['product_images'] ?? [], $product->id);

            //Группа товаров
            $this->serviceProduct->productGroupSave($product->id, $product->group_id, $request['products_ids_group'] ?? []);

            //С этим товаром покупают
            if(isset($request['accessories_product_ids']))
                $product->productAccessories()->sync($request['accessories_product_ids']);
        }
        return  $this->sendResponse($product->id);
    }

    public function view($id)
    {
        $product = Product::with([
            'categories',
            'attributes',
            'specificPrice',
            'images',
            'productAccessories'
        ])->findOrFail($id);

        //фото товара
        $product->pathPhoto = $product->pathPhoto(true);

        //категория
        $categories = $product->categories->pluck('id');


        //атрибуты
        $attributes = [];
        foreach ($product->attributes as $item)
            $attributes[$item->pivot->attribute_id][] = $item->pivot->value;

        
        //картинки
        $images = $product->images->map(function ($item) {
            return  [
                'id'         => $item->id,
                'is_delete'  => 0,
                'image_view' => $item->imagePath(true),
                'value'      => ''
            ];
        });


        //С этим товаром покупают
        $product_accessories = $product->productAccessories->map(function ($item) {
            return  [
                'id'         => $item->id,
                'name'       => $item->name,
                'active'     => $item->active
            ];
        });

        return $this->sendResponse([
            'product'             => $product,
            'product_accessories' => $product_accessories,
            'images'              => $images,
            'attributes'          => $attributes,
            'categories'          => $categories,
            'specific_price'      => $product->specificPrice
        ]);
    }

    public function groupProducts($group_id)
    {
        $products = Product::where('group_id', $group_id)->get();

        $products = $products->map(function ($item) {
            return  [
                'id'         => $item->id,
                'name'       => $item->name,
                'sku'        => $item->sku,
                'price'      => $item->price,
                'active'     => $item->active
            ];
        });

        return  $this->sendResponse($products);
    }

    public function delete($product_id)
    {
        $data = $this->serviceProduct->productDelete($product_id);
        if($data['success'])
        {
            return $this->sendResponse(true);
        }else{
            return $this->sendResponse($data['message'], 422);
        }
    }

    public function cloneProduct(CloneProductRequest $req)
    {
        $req = $req->input('clone_product');
        return  $this->sendResponse(
                    $this->serviceProduct->productClone(
                        $req['product_id'],
                        ['sku' => $req['sku'], 'name' => $req['name']],
                        [
                            'group'               => $req['group'],
                            'photo'               => $req['photo'],
                            'attributes'          => $req['attributes'],
                            'specific_price'      => $req['specific_price'],
                            'product_images'      => $req['product_images'],
                            'reviews'             => $req['reviews'],
                            'product_accessories' => $req['product_accessories'],
                            'questions_answers'   => $req['questions_answers']
                        ]
                    )
        );
    }

    public function priceMinMax(Request $request)
    {
        return $this->sendResponse(
            $this->serviceProduct->priceMinMax($request->all())
        );
    }

    public function productsAttributesFilters(Request $request){
        return $this->sendResponse(
            $this->serviceProduct->productsAttributesFilters($request->all(), false)
        );
    }

}