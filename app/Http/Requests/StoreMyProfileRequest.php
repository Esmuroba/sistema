<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Validation\Validator;
use App\Rules\UniqueContactEmail;

class StoreMyProfileRequest extends FormRequest
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
            'phone' => 'required|numeric|regex:/^[0-9]{10}$/',
            'email' => ['required', 'email', 'max:255', new UniqueContactEmail()]
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => 'El teléfono es requerido',
            'phone.numeric' => 'El teléfono debe ser un número válido.', 
            'phone.regex' => 'El teléfono debe se ser de 10 dígitos.',

            'email.required' => 'El email es requerido.',
            'email.email' => 'El email debe de ser una dirección válida.',
            'email.max_digits' => 'El email debe de ser de máximo 255 caractéres.'
        ];
    }
}
