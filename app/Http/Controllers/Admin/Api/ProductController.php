<?php

namespace App\Http\Controllers\Admin\Api;
use App\Http\Controllers\Admin\AdminController;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\AttributeSet;


use App\Models\ProductGroup;
use App\Models\ProductImage;
use App\Models\SpecificPrice;
use App\Requests\SaveProductRequest;
use App\Tools\UploadableTrait;
use Illuminate\Http\Request;
use DB;
use File;

class ProductController extends AdminController
{
    use UploadableTrait;


    public function list(Request $request)
    {

        $search = trim(mb_strtolower($request->input('search')));

        $list =  Product::with([
                'categories' => function($query){
                    $query->select([DB::raw('t_categories.id'), DB::raw('t_categories.name')]);
                }
            ])
            ->where(function ($query) use ($search){

                        if(!empty($search))
                        {
                            $query->Where(   DB::raw('LOWER(name)'), 'like', "%"  . $search . "%");
                        }

                    })
                    ->OrderBy('id', 'DESC')
                    ->paginate($request->input('perPage', 5));

        return  $this->sendResponse($list);
    }

    public function AttributeSetsMoreInfo(){
        $list =  AttributeSet::with('attributes.values')->get();
        return  $this->sendResponse($list);
    }

    public function save(SaveProductRequest $req){

        $request = $req->all();
        $reqProduct = $request['product'];

        if(empty($reqProduct['id']))
        {
            $productGroup = ProductGroup::create();
            $reqProduct['group_id'] = $productGroup->id;
        }

        $product = Product::findOrNew($reqProduct['id']);
        $old_attribute_set_id = $product->attribute_set_id;

        $product->fill($reqProduct);

        if($product->save())
        {

            if($req->file("product_photo"))
            {
                $product->deletePhoto();
                $photo = $this->uploadFile($request['product_photo'], config('shop.products_path_file') . $product->id . '/');
                $product->photo = $photo;
                $product->save();
            }

            //категория
            $product->categories()->sync($request['categories']);


            //Конкретная цена
            $SpecificPrice = SpecificPrice::firstOrNew(['product_id' => $product->id]);
            $SpecificPrice->fill($request['specific_price']);
            $SpecificPrice->save();


            //Атрибуты

            // Get old product atrribute values
            $oldAttributes = $product->attributeProductValue;

            if(!empty($reqProduct['id']))
                    $product->attributes()->detach();

            if($old_attribute_set_id != $reqProduct['attribute_set_id'] and $old_attribute_set_id > 0)
            {
                foreach ($oldAttributes as $oldAttr)
                {
                    if(File::exists(config('shop.attributes_path_file') . $oldAttr->value)
                        and
                        !$product->AttributeValue::where('attribute_id', $oldAttr->attribute_id)->where('value', $oldAttr->value)->first())
                            File::delete(config('shop.attributes_path_file') . $oldAttr->value);
                }
            }

            foreach ($request['attributes'] as $k => $item)
            {
                if($req->file("attributes.$k.value"))
                {
                    $item['value'] = $this->uploadFile($item['value'], config('shop.attributes_path_file'));

                    //delete old image
                    if($old_attribute_set_id == $reqProduct['attribute_set_id'])
                    {
                        foreach ($oldAttributes as $oldAttr)
                        {
                            if($oldAttr->attribute_id == $item['attribute_id'])
                            {
                                if(!AttributeValue::where('attribute_id', $oldAttr->attribute_id)->where('value', $oldAttr->value)->first())
                                    File::delete(config('shop.attributes_path_file') . $oldAttr->value);
                            }
                        }
                    }

                }

                $item['value'] = is_array($item['value']) ? $item['value'] : [$item['value']];

                foreach ($item['value'] as $value)
                    $product->attributes()->attach([$item['attribute_id'] => ['value' => $value]]);
            }




            //Картинки
            if (!empty($request['product_images']))
            {

                foreach ($request['product_images'] as $key => $item)
                {
                    //добавить
                    if(intval($item['is_delete']) == 0)
                    {
                        if($req->file("product_images.$key.value"))
                            $images = [
                                'product_id' => $product->id,
                                'name' => $this->uploadFile($item['value'], config('shop.products_path_file') . $product->id . '/'),
                                'order' => $key
                            ];
                        else
                            $images = ['order' => $key];

                        $attribute = ProductImage::findOrNew($item["id"]);
                        $attribute->fill($images);
                        $attribute->save();
                    //удалить
                    }else{
                        ProductImage::destroy($item['id']);
                    }
                }
            }


            //Группа товаров
            $products = Product::select('id')->where('group_id', $product->group_id)->whereNotIn('id', $request['products_ids_group'])->get();
            foreach ($products as $item)
            {
                if($item->id == $product->id) continue;

                $productGroup = ProductGroup::create();
                Product::where('id', $item->id)->update(['group_id' => $productGroup->id]);
            }

            foreach ($request['products_ids_group'] as $products_id)
            {
                if($products_id == $product->id) continue;

                $productGroupId     = Product::find($products_id)->group_id;
                $countGroupProducts = Product::where('group_id', $productGroupId)->count();

                Product::where('id', $products_id)->update(['group_id' => $product->group_id]);

                if($countGroupProducts == 1)
                    ProductGroup::destroy($productGroupId);
            }

        }
        return  $this->sendResponse($product->id);
    }

    public function view($id)
    {
        $product = Product::with(['categories', 'attributeProductValue', 'specificPrice', 'images'])->findOrFail($id);

        //категория
        $categories = $product->categories->pluck('id');
        unset($product->categories);
        $product->categories = $categories;


        //атрибуты
        $data = [];
        foreach ($product->attributeProductValue as $item)
            $data[$item->attribute_id][] = $item->value;
        unset($product->attributeProductValue);
        $product->attribute_product_value = $data;

        
        //картинки
        $images = $product->images->map(function ($item) {
            return  [
                'id'         => $item->id,
                'is_delete'  => 0,
                'image_view' => $item->imagePath(),
                'value'      => ''
            ];
        });
        unset($product->images);
        $product->images = $images;


        //фото товара
        $product->product_photo = $product->pathPhoto();


        return  $this->sendResponse($product);
    }

    public function groupProducts($group_id)
    {
        $products = Product::where('group_id', $group_id)->get();
        return  $this->sendResponse($products);
    }



}