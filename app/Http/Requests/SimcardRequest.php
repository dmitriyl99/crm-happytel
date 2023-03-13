<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimcardRequest extends FormRequest
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
            'simcards' => 'required',
            //'regions' => 'required',
            'region_groups' => 'required',
            // 'price' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'ssid.required' => 'В поле необходимо ввести SSID.',
//             'regions.required' => 'В поле необходимо ввести Регион.',
            'region_groups.required' => 'В поле необходимо ввести Регион группа.',
            'plans.required' => 'В поле необходимо ввести Тариф.',
            'price.required' => 'В поле необходимо ввести Цена.',
        ];
    }
}
