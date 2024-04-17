<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\SelectUserRole;

class StoreUserRequest extends FormRequest
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
            'collaborator_id' => 'required|numeric',
            'collaborator' => 'required|string',
            'email' => 'required|unique:users|email|max:255',
            'role' => ['required', new SelectUserRole()]
        ];
    }

    public function messages()
    {
        return [
            'collaborator.required' => 'El Colaborador es requerido.',
            'collaborator.string' => 'El nombre del Colaborador debe de ser válido.',
            'email.required' => 'El Email es requerido.',
            'email.unique' => 'Este Email ya se encuentra registrado, ingrese uno nuevo.',
            'email.email' => 'El Email debe de tener una dirección válida.',
            'email.max' => 'El Email no debe de superar los 255 caracteres.',
            'role.required' => 'El Rol es requerido.'
        ];
    }
}
