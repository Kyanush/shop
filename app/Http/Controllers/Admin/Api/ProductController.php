<?php

namespace App\Http\Controllers\Admin\Api;
use App\Http\Controllers\Admin\AdminController;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\AttributeSet;


use App\Models\ProductGroup;
use App\Models\ProductImage;
use App\Models\SpecificPrice;
use App\Requests\CloneProductRequest;
use App\Requests\SaveProductRequest;
use App\Services\ServiceAttributeProductValue;
use App\Tools\UploadableTrait;
use Illuminate\Http\Request;
use DB;
use File;

class ProductController extends AdminController
{
    use UploadableTrait;
    private $serviceAttrProductVal;

    public function __construct(ServiceAttributeProductValue $serviceAttrProductVal)
    {
        parent::__construct();
        $this->serviceAttrProductVal = $serviceAttrProductVal;
    }

    public function list(Request $request)
    {

        $search = trim(mb_strtolower($request->input('search')));

        $list =  Product::withTrashed()->with([
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

    public function save(SaveProductRequest $req)
    {

        $request = $req->all();

        $reqProduct = $request['product'];
        $reqProduct['deleted_at'] = intval($reqProduct['deleted_at']) == 1 ? date('Y-m-d H:i:s') : NULL;

        if(empty($reqProduct['id']))
        {
            $productGroup = ProductGroup::create();
            $reqProduct['group_id'] = $productGroup->id;
        }

        $product = Product::withTrashed()->findOrNew($reqProduct['id']);






        $old_attribute_set_id = $product->attribute_set_id;



        $product->fill($reqProduct);

        if($product->save())
        {

            if($req->file("photo"))
            {
                $product->deletePhoto();
                $product->photo = $this->uploadFile($request['photo'], $product->productFileFolder());
                $product->save();
            }

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

            // Get old product atrribute values
            $oldAttributes = $product->attributes;

            if(!empty($reqProduct['id']))
                    $product->attributes()->detach();

            if($old_attribute_set_id != $reqProduct['attribute_set_id'] and $old_attribute_set_id > 0)
            {
                foreach ($oldAttributes as $oldAttr)
                {
                    $this->serviceAttrProductVal->deleteImage($oldAttr->pivot->attribute_id, $oldAttr->pivot->value);
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
                            if($oldAttr->pivot->attribute_id == $item['attribute_id'])
                            {
                                $this->serviceAttrProductVal->deleteImage($oldAttr->pivot->attribute_id, $oldAttr->pivot->value);
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
                                'name' => $this->uploadFile($item['value'], $product->productFileFolder()),
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
            if(is_array($request['products_ids_group']))
            {
                $products = Product::withTrashed()->select('id')->where('group_id', $product->group_id)->whereNotIn('id', $request['products_ids_group'])->get();
                foreach ($products as $item)
                {
                    if($item->id == $product->id) continue;

                    $productGroup = ProductGroup::create();
                    Product::withTrashed()->where('id', $item->id)->update(['group_id' => $productGroup->id]);
                }

                foreach ($request['products_ids_group'] as $products_id)
                {
                    if($products_id == $product->id) continue;

                    $productGroupId     = Product::withTrashed()->find($products_id)->group_id;
                    $countGroupProducts = Product::withTrashed()->where('group_id', $productGroupId)->count();

                    Product::withTrashed()->where('id', $products_id)->update(['group_id' => $product->group_id]);

                    if($countGroupProducts == 1)
                        ProductGroup::destroy($productGroupId);
                }
            }

        }
        return  $this->sendResponse($product->id);
    }

    public function view($id)
    {
        $product = Product::withTrashed()->with(['categories', 'attributes', 'specificPrice', 'images'])->findOrFail($id);

        //категория
        $categories = $product->categories->pluck('id');
        unset($product->categories);
        $product->categories = $categories;


        //атрибуты
        $data = [];
        foreach ($product->attributes as $item)
            $data[$item->pivot->attribute_id][] = $item->pivot->value;
        unset($product->attributes);
        $product->attributes = $data;

        
        //картинки
        $images = $product->images->map(function ($item) {
            return  [
                'id'         => $item->id,
                'is_delete'  => 0,
                'image_view' => $item->imagePath(true),
                'value'      => ''
            ];
        });
        unset($product->images);
        $product->images = $images;


        //фото товара
        $product->photo = $product->pathPhoto(true);


        return  $this->sendResponse($product);
    }

    public function groupProducts($group_id)
    {
        $products = Product::withTrashed()->where('group_id', $group_id)->get();
        return  $this->sendResponse($products);
    }

    public function delete($id)
    {

        $product = Product::withTrashed()->find($id);

        //категории
        $product->categories()->detach();

        //картинки
        if($product->images)
            $product->images()->delete();

        //арритуты
        if($product->attributes)
        {
            foreach ($product->attributes as $item)
                if($item->type == 'media')
                    $this->serviceAttrProductVal->deleteImage($item->pivot->attribute_id, $item->pivot->value);
            $product->attributes()->detach();
        }

        //папка товара
        File::deleteDirectory($product->productFileFolder());

        //скидки
        if($product->specificPrice)
            $product->specificPrice->delete();


        $group_id = $product->group_id;

        if($product->delete())
        {
            $countGroupProducts = Product::withTrashed()->where('group_id', $group_id)->count();
            if(!$countGroupProducts)
                ProductGroup::destroy($group_id);

            return  $this->sendResponse(true);
        }
        return  $this->sendResponse(false);
    }


    public function cloneProduct(CloneProductRequest $req)
    {
        $req = $req->input('clone_product');

        $product = Product::withTrashed()->find($req['product_id']);

        // Create clone object
        $clone = $product->replicate();

        //Группа товаров
        if(!$req['group'])
            $clone->group_id = ProductGroup::create()->id;

        $clone->sku  = $req['sku'];
        $clone->name = $req['name'];

        //Save cloned product
        $clone->push();

        //Фото товара
        if($req['photo'] and $product->pathPhoto())
        {
            $clone->photo = $this->copyFile($product->pathPhoto(), $clone->productFileFolder());
            $clone->save();
        }


        //категория
        foreach ($product->categories as $item)
            $clone->categories()->attach([$item->id]);

        //атрибуты
        if($req['attributes'])
        {
            foreach ($product->attributes as $item)
                $clone->attributes()->attach([$item->pivot->attribute_id => ['value' =>  $item->pivot->value]]);
        }

        //Скидки
        if($req['specific_price'])
        {
            $specificPrice = $product->specificPrice->replicate();
            $specificPrice->product_id = $clone->id;
            $specificPrice->push();
        }

        //Картинки
        if($req['product_images'])
        {
            $images = $product->images;
            if($images)
            {
                foreach ($images as $image)
                {
                    $data = $image->toArray();
                    $data['product_id'] = $product->id;
                    $data['name'] = $this->copyFile($image->imagePath(), $clone->productFileFolder());
                    $clone->images()->create($data);
                }
            }
        }


        return  $this->sendResponse(true);
    }




}