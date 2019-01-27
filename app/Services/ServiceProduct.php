<?php
namespace App\Services;

use App\Models\Attribute;
use App\Models\AttributeProductValue;
use App\Models\Order;
use File;
use App\Tools\UploadableTrait;
use App\Models\ProductGroup;
use App\Models\Product;
use App\Models\ProductImage;


class ServiceProduct
{

    use UploadableTrait;
    private $serviceAttrProductVal, $model;

    public function __construct(ServiceAttributeProductValue $serviceAttrProductVal)
    {
        $this->serviceAttrProductVal = $serviceAttrProductVal;
        $this->model = new Product();
    }


    public function productDelete($product_id)
    {
        if(Order::whereHas('products', function ($query) use ($product_id){
            $query->where('product_id', $product_id);
        })->first())
            return [
                'message' => 'Вы не можете удалить, есть привязанные заказы!',
                'success' => false
            ];

        $product = $this->model::find($product_id);

        //папка товара
        File::deleteDirectory($product->productFileFolder());

        //категории
        $product->categories()->detach();

        //арритуты
        if($product->attributes)
        {
            foreach ($product->attributes as $item)
                if($item->type == 'media')
                    $this->serviceAttrProductVal->deleteImage($item->pivot->attribute_id, $item->pivot->value);
            $product->attributes()->detach();
        }

        //картинки
        $product->images()->delete();

        //аксессуары
        $product->productAccessories()->detach();

        //Отзывы
        $product->reviews()->delete();

        //Вопрос-ответ
        $product->questionsAnswers()->delete();

        //подписка
        $product->subscribe()->delete();

        //скидки
        $product->specificPrice()->delete();



        $group_id = $product->group_id;

        if($product->delete())
        {
            //Группа товаров
            $countGroupProducts = $this->model::where('group_id', $group_id)->count();
            if(!$countGroupProducts)
                ProductGroup::destroy($group_id);

            return [
                'message' => 'Ok',
                'success' => true
            ];
        }

        return [
            'message' => 'Ошибка',
            'success' => false
        ];
    }

    public function productClone($product_id, array $data, array $copy = [])
    {
        $product = $this->model::find($product_id);

        $group               = $copy['group']               ?? false;
        $photo               = $copy['photo']               ?? false;
        $attributes          = $copy['attributes']          ?? false;
        $specific_price      = $copy['specific_price']      ?? false;
        $product_images      = $copy['product_images']      ?? false;
        $reviews             = $copy['reviews']             ?? false;
        $product_accessories = $copy['product_accessories'] ?? false;
        $questions_answers   = $copy['questions_answers']   ?? false;


        // Create clone object
        $clone = $product->replicate();

        //Группа товаров
        if(!$group)
            $clone->group_id = ProductGroup::create()->id;

        $data['url'] = '';
        $clone->fill($data);

        //Save cloned product
        $clone->push();

        //Фото товара
        if($photo and $product->pathPhoto())
        {
            $clone->photo = $this->copyFile($product->pathPhoto(), $clone->productFileFolder());
            $clone->save();
        }

        //категория
        foreach ($product->categories as $item)
            $clone->categories()->attach([$item->id]);

        //атрибуты
        if($attributes)
        {
            foreach ($product->attributes as $item)
                $clone->attributes()->attach([$item->pivot->attribute_id => ['value' =>  $item->pivot->value]]);
        }

        //Скидки
        if($specific_price and $product->specificPrice)
        {
            $specificPrice = $product->specificPrice->replicate();
            $specificPrice->product_id = $clone->id;
            $specificPrice->push();
        }

        //Картинки
        if($product_images)
        {
            $images = $product->images;
            if($images)
            {
                foreach ($images as $image)
                {
                    $productImages = $image->toArray();
                    $productImages['product_id'] = $product->id;
                    $productImages['name'] = $this->copyFile($image->imagePath(), $clone->productFileFolder());
                    $clone->images()->create($productImages);
                }
            }
        }

        //С этим товаром покупают
        if($product_accessories)
        {
           foreach ($product->productAccessories as $item)
               $clone->productAccessories()->attach([$item->pivot->accessory_product_id]);
        }

        //Отзывы
        if($reviews)
        {
            foreach($product->reviews()->get() as $item)
            {
                $data = $item->toArray();
                unset($data['id']);
                $clone->reviews()->create($data);
            }
        }

        //Вопросы-ответы
        if($questions_answers)
        {
            foreach($product->questionsAnswers()->get() as $item)
            {
                $data = $item->toArray();
                unset($data['id']);
                $clone->questionsAnswers()->create($data);
            }
        }

        return true;
    }

    //Группа товаров
    public function productGroupSave(int $product_id, int $product_group_id, array $product_ids)
    {
        if(!is_array($product_ids) or count($product_ids) == 0)
            return false;

            $products = $this->model::select('id')->where('group_id', $product_group_id)->whereNotIn('id', $product_ids)->get();
            foreach ($products as $item)
            {
                if($item->id == $product_id) continue;

                $productGroup = ProductGroup::create();
                $this->model::where('id', $item->id)->update(['group_id' => $productGroup->id]);
            }

            foreach ($product_ids as $item_product_id)
            {
                if($item_product_id == $product_id) continue;

                $productGroupId     = $this->model::find($item_product_id)->group_id;
                $countGroupProducts = $this->model::where('group_id', $productGroupId)->count();

                $this->model::where('id', $item_product_id)->update(['group_id' => $product_group_id]);

                if($countGroupProducts == 1)
                    ProductGroup::destroy($productGroupId);
            }

        return true;
    }


    //Картинки
    public function productImagesSave(array $images, $product_id)
    {
        //id
        //value
        //is_delete 0-нет, 1-да

        if (empty($images))
            return false;

        $product = $this->model::find($product_id);

        foreach ($images as $key => $item)
        {
            //добавить
            if(intval($item['is_delete']) == 0)
            {
                if(is_uploaded_file($item['value']))
                    $images_data = [
                        'product_id' => $product_id,
                        'name'       => $this->uploadFile($item['value'], $product->productFileFolder()),
                        'order'      => $key
                    ];
                else
                    $images_data = ['order' => $key];

                $attribute = ProductImage::findOrNew($item["id"]);
                $attribute->fill($images_data);
                $attribute->save();
                //удалить
            }else{
                ProductImage::destroy($item['id']);
            }
        }
        return true;
    }


    public function productAttributesSave(int $product_id, array $attributes, bool $new_attributes)
    {
        if(empty($product_id) or count($attributes) == 0)
            return false;

        $product = $this->model::find($product_id);
        //Атрибуты

        //старые атрибуты
        $oldAttributes = $product->attributes;

        //удалить все атрибуты
        $product->attributes()->detach();

        if($new_attributes)
        {
            foreach ($oldAttributes as $oldAttr)
            {
                $this->serviceAttrProductVal->deleteImage($oldAttr->pivot->attribute_id, $oldAttr->pivot->value);
            }
        }

        foreach ($attributes as $k => $item)
        {
            $item['value'] = $item['value'] ?? '';

            if(!is_array($item['value']))
                if(is_uploaded_file($item['value']))
                {
                    $item['value'] = $this->uploadFile($item['value'], config('shop.attributes_path_file'));

                    //delete old image
                    if(!$new_attributes)
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
        return true;
    }


    public function priceMinMax($filters)
    {
        return [
            'max' => $this->model::filters($filters)->filtersAttributes($filters)->max('price'),
            'min' => $this->model::filters($filters)->filtersAttributes($filters)->min('price')
        ];
    }

    public function productsAttributesFilters($filters, $useInFilter = true)
    {
       $attributeProductValue = AttributeProductValue::select(['attribute_id', 'value'])
            ->whereHas('product', function($query) use ($filters){
                $query->filters($filters);
                $query->filtersAttributes($filters);
            })
            ->whereHas('attribute', function($query) use ($useInFilter){
                if($useInFilter)
                    $query->useInFilter();
                else
                    $query->whereIn('type', ['multiple_select', 'dropdown']);
            })
            ->where(function ($query){
                $query->whereNotNull('value');
                $query->orWhere('value', '!=', "''");
            })
            ->GroupBy(['attribute_id', 'value'])
            ->get();

        $attribute_ids = [];
        $values = [];

        foreach($attributeProductValue as $value)
        {
            $attribute_ids[$value->attribute_id] = $value->attribute_id;
            $values[$value->value] = $value->value;
        }

        return Attribute::whereIn('id', $attribute_ids)->with(['values' => function($query) use ($values){
            $query->whereIn('value', $values);
        }])
        ->whereHas('values', function ($query) use ($values){
            $query->whereIn('value', $values);
        })->get();
    }

}