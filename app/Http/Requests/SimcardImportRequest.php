<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimcardImportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'mimes:xlsx,xls'],
            'agent_id' => ['required', 'numeric'],
            'region_groups' => ['required', 'array'],
            'region_groups.*' => ['required', 'numeric']
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'Необходимо выбрать эксель файл',
            'file.file' => 'Необходимо выбрать эксель файл',
            'file.mimes' => 'Необходимо выбрать эксель файл',
            'region_groups.required' => 'В поле необходимо ввести Регион группа.',
        ];
    }
}
