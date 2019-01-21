<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Illuminate\Validation\Rule;

class OneClickOrderRequest extends FormRequest
{

    public function rules()
    {
        $rules = [
            'product_id' => ['required',
                    Rule::exists('products', 'id')->where(function ($query){
                        $query->where('active', 1);
                    })
            ]
        ];
        if(!Auth::check())
        {
            $rules['email'] = 'required|max:255';
            $rules['name']  = 'required|max:255';
            $rules['phone'] = 'required|max:17|min:17';
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'product_id' => "'Товар'",
            'email'      => "'Email'",
            'name'       => "'Имя'",
            'phone'      => "'Телефон'"
        ];
    }

}