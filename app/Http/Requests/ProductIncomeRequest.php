<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductIncomeRequest extends FormRequest
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
            'name' => 'required:listproduct,name,'.$this->product,
            'barcode' => 'sometimes|nullable|string'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Необходимо ввести название в поле.',
        ];
    }
}
