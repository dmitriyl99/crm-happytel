<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$this->user,
            'role' => 'required',
            'agent_id' => 'required'
        ];
        if($this->method() == 'POST' || request()->password)
        {
            $rules['password'] = 'min:6|required_with:password_confirmation|same:password_confirmation';
            $rules['password_confirmation'] = 'min:6';
        }
        return $rules;
    }
}
