<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
            'name' => 'required|string|max:125'
        ];
    }

    public function messages()
    {
        return [
            // 'name.required' => 'El nombre es requerido.',
            'name.unique' => 'El nombre del rol ya se encuentra registrado.',
            'name.string' => 'El nombre debe de contener letras.',
            'name.max' => 'La longitud debe de ser de máximo 125 caracteres.'
        ];
    }
}
