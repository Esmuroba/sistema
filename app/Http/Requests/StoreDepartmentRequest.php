<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
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
            'name' => 'required|max:50',
            'phone' => 'required|regex:/^[0-9]{10}$/|max:10',
            'ext' => 'nullable|max:5'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El Departamento debe de tener un nombre.',
            'name.max' => 'La longitud debe ser de máximo 50 caracteres.',
            'phone.required' => 'El teléfono es requerido.',
            'phone.regex' => 'El formato del número de teléfono no es válido.',
            'phone.max' => 'El número de teléfono debe de ser de 10 dígitos.',
            'ext.max' => 'El número de Extensión debe de ser de 5 dígitos.'
        ];
    }
}
