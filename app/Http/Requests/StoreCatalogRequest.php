<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCatalogRequest extends FormRequest
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
            'name' => 'required|max:50|string',
            'description' => 'nullable|max:150|string',
            'code' => 'required|max:15|string'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es requerido.',
            'name.max' => 'La longitud debe de ser de máximo 50 caracteres.',
            'name.string' => 'Dede de ser una cadena de téxto',

            'description.max' => 'La longitud debe de ser de máximo 150 caracteres.',
            'description.string' => 'Dede de ser una cadena de téxto',

            'code.required' => 'El código es requerido.',
            'code.max' => 'La longitud debe de ser de máximo 15 caracteres.',
            'code.string' => 'Dede de ser una cadena de téxto'
        ];
    }
}
