<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
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
            'provider_id' => 'required',
            'regionIds' => 'required',
            'name' => 'required|max:1000',
            'status' => 'required',
            'expiry_day' => 'required|numeric',
            // 'quantity_minut' => 'required|numeric',
            // 'quantity_internet' => 'required|numeric',
            // 'traffic_type' => 'required',
            // 'quantity_sms' => 'required|numeric',
            'price_arrival' => 'required|numeric',
            'price_sell' => 'required|numeric',
            'provder_id' => 'requred',
            'type' => 'required|in:normal,additional',
            
        ];
    }
    
    public function messages()
    {
        return [
           'type.in' => "Are youu hacking me ?"  
        ];
    }
}
