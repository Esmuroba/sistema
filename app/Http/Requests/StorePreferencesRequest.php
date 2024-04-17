<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePreferencesRequest extends FormRequest
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
            'payment_scheme' => 'required|numeric',
            'street' => 'required|string|max:255',
            'out_num' => 'nullable|numeric',
            'int_num' => 'nullable|numeric',
            'cp' => 'required|numeric|min:5|max:5',
            'suburb' => 'required|string|max:50',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'phone' => 'required|numeric|min:10|max:10',
            'ext' => 'nullable|max:5',
            'logo' => 'nullable|string|max:255'
        ];
    }

    public function messages()
    {
        return [
            'payment_scheme.required' => 'El Esquema de Cobro es requerido.',
            'payment_scheme.numeric' => 'Debe elegir un Esquema de Cobro válido.',

            'street.required' => 'La Calle es requerida.',
            'street.string' => 'Debe ingresar una Calle válida.',
            'street.max' => 'La longitud es de máximo 255 caracteres.',

            'out_num.numeric' => 'Debe ingresar un Número válido.',
            
            'int_num.numeric' => 'Debe ingresar un Número válido.',

            'cp.required' => 'El Código Postal es requerido.',
            'cp.numeric' => 'Debe ingresar un Código Postal válido.',
            'cp.min' => 'La longitud es de 5 dígitos.',
            'cp.max' => 'La longitud es de 5 dígitos.',

            'suburb.required' => 'La Colonia es requerida.',
            'suburb.string' => 'Debe ingresar una Colonia válida.',
            'suburb.max' => 'La longitud es de máximo 50 caracteres.',

            'city.required' => 'La ciudad es requerida.',
            'city.string' => 'Debe ingresar una Ciudad válida.',
            'city.max' => 'La longitud es de máximo 100 caracteres.',

            'state.required' => 'El Estado es requerido.',
            'state.string' => 'Debe ingresar un Estado válido.',
            'state.max' => 'La longitud es de máximo 100 caracteres.',

            'phone.required' => 'El Teléfono es requerido.',
            'phone.numeric' => 'Debe ingresar un Teléfono válido.',
            'phone.min' => 'La longitud es de 10 dígitos.',
            'phone.max' => 'La longitud es de 10 dígitos.',

            'ext.max' => 'La longitud es de máximo 5 dígitos',

            'logo.string' => 'Debe ingresar una Imagen válida.',
            'logo.max' => 'El nombre de la imagen debe ser de máximo 255 caracteres.'
        ];
    }
}
