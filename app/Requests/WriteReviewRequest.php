<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class WriteReviewRequest extends FormRequest
{

    public function rules()
    {
        $rules = [
            'product_id' => 'exists:products,id',
            'minus'      => 'max:1000',
            'plus'       => 'max:1000',
            'email'      => 'nullable|email',
            'comment'    => 'required|max:1000',
            'name'       => 'required|max:255',
            'rating'     => 'required|integer|max:5|min:1',
            'created_at' => 'date_format:"Y-m-d H:i:s"'
        ];
        return $rules;
    }

    public function attributes()
    {
        return [
            'product_id' => "'Товар ID'",
            'minus'      => "'Недостатки'",
            'plus'       => "'Достоинства'",
            'email'      => "'Ваш e-mail'",
            'comment'    => "'Комментарий'",
            'name'       => "'Ваше имя'",
            'rating'     => "'Оценка'",
            'created_at' => "'Оценка'"
        ];
    }

}