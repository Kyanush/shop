<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SaveCategoryRequest extends FormRequest
{

    public function rules()
    {
        $data = $this->request->all();
        $id   = $data['category']['id'] ?? 0;

        return [
            'category.name' => ['required', 'unique:categories,name' . ($id ? (',' . $id . ',id') : '')],
            'category.url' => ['nullable', 'unique:categories,url' . ($id ? (',' . $id . ',id') : '')]
        ];
    }

    public function attributes()
    {
        return [
            'category.name' => "'Название'",
            'category.url' => "'Url'"
        ];
    }

}