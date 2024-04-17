<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBankAccountRequest extends FormRequest
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
            'name' => 'required|string|max:25',
            'bank' => 'required|numeric',
            'account_number' => 'required|numeric|digits_between:10,12',
            'key_account' => 'required|numeric|regex:/^[0-9]{18}$/'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El alias de la cuenta es requerido.',
            'name.string' => 'El alias de la cuenta debe de ser una cadena válida.',
            'name.max' => 'El alias de la cuenta debe de ser de máximo 25 caracteres.',

            'bank.required' => 'El banco es requerido.',
            'bank.numeric' => 'Debe elegir una opción válida.',
                
            'account_number.required' => 'El número de cuenta es requerido.',
            'account_number.numeric' => 'El número de cuenta debe de contener únicamente números.',
            'account_number.max' => 'El número de cuenta debe de ser de máximo 12 dígitos.',

            'key_account.required' => 'La cuenta clabe es requerida.',
            'key_account.numeric' => 'La cuenta clabe debe de contener únicamente números.',
            'key_account.regex' => 'La cuenta clabe debe de ser de 18 dígitos.'
        ];
    }
}
