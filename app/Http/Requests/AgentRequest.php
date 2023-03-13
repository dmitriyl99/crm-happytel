<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgentRequest extends FormRequest
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

        $rules = [
            'title' => 'required',
            //'name' => 'required',
            'phone' => 'required',
            'status' => 'required',
            //'login' => 'required|unique:users,email,'.request()->user_id,
        ];

        if(!request()->user_id){
            //$rules['password'] = 'required';
        }
        return $rules;
    }
}
