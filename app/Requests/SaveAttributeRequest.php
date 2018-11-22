<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SaveAttributeRequest extends FormRequest
{

    public function rules()
    {
        $attribute_id = $this->input('attribute.id');

        $rules = [
            'attribute.id' => (!empty($attribute_id) ? 'exists:attributes,id' : 'nullable'),
            'attribute.name' => 'required|max:255',
            'attribute.type' => 'required',
        ];

        if($this->input('attribute.type') == 'multiple_select' or $this->input('attribute.type') == 'dropdown')
            $rules['attribute.values.*.value'] = 'required';

        return $rules;
    }

    public function attributes()
    {
        return [
            'attribute.id'   => "'id'",
            'attribute.name' => "'Название'",
            'attribute.type' => "'Тип'",
            'attribute.values.*.value' => "'Значение по умолчанию'"
        ];
    }

}