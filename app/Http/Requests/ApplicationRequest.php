<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
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
//         $rules =  [
//             'region_id' => 'required',
//             'simcard_id' => 'required',
//             'plan_id' => 'required',
//             'date_start' => 'required',
//             'date_finish' => 'required',
//             'payment_type' => 'required'
//         ];
        $rules =  [
            'region_groups' => 'required',
            'simcards' => 'required',
            'plans' => 'required',
            'date_start' => 'required',
            'date_finish' => 'required',
            'payment_type' => 'required'
        ];
//         if(!request()->customer_id){
//             //$rules['full_name'] = 'required';
//             $rules['phone'] = 'required|unique:customers,phone,'.request()->customer_id;
//         }
        return $rules;
    }
}
