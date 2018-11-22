<?php
namespace App\Requests;
use App\Models\Attribute;
use Illuminate\Foundation\Http\FormRequest;
use Request;
use Illuminate\Validation\Rule;

class SaveProductRequest extends FormRequest
{

    public function rules()
    {
        $product_id   = $this->input('product.id');

        $rules = [
            'product.id'          => (!empty($product_id) ? 'exists:products,id' : 'nullable'),
            'product.attribute_set_id' => 'integer|exists:attribute_sets,id',
            'product.name'        => ['max:255', 'required', 'unique:products,name' . ($product_id ? (',' . $product_id . ',id') : '')],
            'product.description' => 'max:1000|required',
            'product.tax_id'      => 'integer|exists:taxes,id',
            'product.price'       => 'numeric|required|min:1',
            'product.sku'         => ['max:100', 'unique:products,sku' . ($product_id ? (',' . $product_id . ',id') : '')],
            'product.stock'       => 'integer',
            'product.active'      => 'required|integer|min:0|max:1',

            'categories'          => 'required|exists:categories,id',
            'categories.*'        => 'required|exists:categories,id',

            'attributes'          => 'required',
            'attributes.*'        => 'required',

            'specific_price.reduction'       => 'nullable|numeric|min:0',
            'specific_price.discount_type'   => 'nullable|max:10',

            'product_images.*.value'         => 'nullable|image|mimes:jpeg,jpg,png|max:10000',
        ];

        if ($this->input('specific_price.reduction') > 0)
        {
            $rules['specific_price.start_date']      = 'nullable|date_format:"Y-m-d H:i:s"';
            $rules['specific_price.expiration_date'] = 'nullable|date_format:"Y-m-d H:i:s"';
        }

        foreach ($this->input('attributes') as $key => $item)
        {
            $isRequired = Attribute::IsRequired()->find($item['attribute_id']);
            if($isRequired and empty($item['value']))
            {
                $rules["attributes.$key.value"] = 'required';
            }
        }


        if($this->file("product_photo"))
            $rules['product_photo'] = 'required|image|mimes:jpeg,jpg,png|max:10000';

        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'product.id'          => "'Название'",
            'product.attribute_set_id' => "'Наборы атрибутов'",
            'product.name'        => "'Название'",
            'product.description' => "'Описание'",
            'product.tax_id'      => "'Налог'",
            'product.price'       => "'Цена'",
            'product.sku'         => "'SKU'",
            'product.stock'       => "'Количество на складе'",
            'product.active'      => "'Статус'",

            'product_photo'       => "'Фото товара'",

            'categories'          => "'Категории'",
            'categories.*'        => "'Категории'",

            'attributes'          => "'Наборы атрибутов'",
            'attributes.*'        => "'Наборы атрибутов'",

            'specific_price.reduction'       => "'Снижение'",
            'specific_price.discount_type'   => "'Тип скидки'",
            'specific_price.start_date'      => "'Дата начала'",
            'specific_price.expiration_date' => "'Дата окончания срока'",

            'product_images.*.value'         => "'Фото'",
        ];

        foreach ($this->input('attributes') as $key => $item)
        {
            $attribute = Attribute::select('name')->find($item['attribute_id']);
            $attributes["attributes.$key.value"] = "'" . $attribute->name . "'";
        }

        return $attributes;
    }

}