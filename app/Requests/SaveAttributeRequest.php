<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SaveAttributeRequest extends FormRequest
{

    public function rules()
    {
        $data = $this->request->all();
        $data = $data['attribute'];

        return [
            'attribute.id' => (!empty($data['id']) ? 'exists:attributes,id' : 'nullable'),
            'attribute.name' => 'required|max:255',
            'attribute.type' => 'required',
            'attribute.values.*.value' => 'required'
        ];
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