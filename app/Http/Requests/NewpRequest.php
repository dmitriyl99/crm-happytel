<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => 'required',
            'count' => 'required',
            'payment_type' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'product_id.required' => 'Необходимо выбрать продукт',
            'count.required' => 'Необходимо ввести количество.',
            'payment_type.required' => 'Необходимо ввести вид платежа',
        ];
    }
}
