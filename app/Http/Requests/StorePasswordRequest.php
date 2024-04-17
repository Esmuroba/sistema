<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StorePasswordRequest extends FormRequest
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
            'password' => [
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->uncompromised()
            ],
            'password_confirmation' => 'required|same:password'
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'La contraseña es requerida.',
            'password.min' => 'La longitud de la contraseña debe ser de mínimo 8 caracteres.',

            'password_confirmation.required' => 'La confirmación es requerida.',
            'password_confirmation.same' => 'Debe coincidir con la contraseña introducida.'
        ];
    }
}
