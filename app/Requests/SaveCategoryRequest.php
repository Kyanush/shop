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
            'category.slug' => ['required', 'unique:categories,slug' . ($id ? (',' . $id . ',id') : '')]
        ];
    }

    public function attributes()
    {
        return [
            'category.name' => "'Название'",
            'category.slug' => "'Slug'"
        ];
    }

}