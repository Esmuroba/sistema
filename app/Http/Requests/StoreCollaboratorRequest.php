<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCollaboratorRequest extends FormRequest
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
            'first_name' => 'required|string|max:100',
            'second_name' => 'nullable|string|max:100',
            'first_surname' => 'required|string|max:100',
            'last_surname' => 'required|string|max:100',
            'gender' => 'required',
            'birthdate' => 'required|date',
            'curp' => 'required|string|min:18|max:18',
            'phone' => 'required|min:10|max:10',
            'email' => 'required|string|email|max:255',
            'current_salary' => 'required|numeric',
            'daily_salary' => 'required|numeric',
            'previous_salary' => 'nullable|numeric',
            'enterprise' => 'required|numeric',
            'date_admission' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'El Nombre es requerido.',
            'first_name.string' => 'Debe ingresar un nombre válido.',
            'first_name.max' => 'La longitud del nombre debe de ser de máximo 100 caracteres.',

            'second_name.string' => 'Debe ingresar un nombre válido.',
            'second_name.max' => 'La longitud del nombre debe de ser de máximo 100 caracteres.',

            'first_surname.required' => 'El apellido es requerido.',
            'first_surname.string' => 'Debe ingresar un apellido válido.',
            'first_surname.max' => 'La longitud del apellido debe de ser de máximo 100 caracteres.',

            'last_surname.required' => 'El apellido es requerido.',
            'last_surname.string' => 'Debe ingresar un apellido válido.',
            'last_surname.max' => 'La longitud del apellido debe de ser de máximo 100 caracteres.',

            'gender.required' => 'El Género es requerido',

            'birthdate.required' => 'La Fecha de Nacimiento es requerida.',
            'birthdate.date' => 'Debe ingresar una fecha válida.',

            'curp.required' => 'La CURP es requerida.',
            'curp.string' => 'Debe ingresar una CURP válida.',
            'curp.min' => 'La longitud de la CURP debe de ser de 18 caracteres.',
            'curp.max' => 'La longitud de la CURP debe de ser de 18 caracteres.',

            'phone.required' => 'El Teléfono es requerido.',
            'phone.min' => 'La longitud del Teléfono debde de ser de 10 dígitos.',
            'phone.max' => 'La longitud del Teléfono debde de ser de 10 dígitos.',

            'email.required' => 'El Email es requerido.',
            'email.string' => 'Debe ingresar un Email válido.',
            'email.email' => 'Debe ingresar una dirección de Email válida.',
            'email.max' => 'La longitud del Email debe de ser de máximo 255 caracteres.',

            'current_salary.required' => 'El Salario Mensual es requerido.',
            'current_salary.numeric' => 'Debe ingresar números válidos.',

            'daily_salary.required' => 'El Salario Diario es requerido.',
            'daily_salary.numeric' => 'Debe ingresar números válidos.',

            'previous_salary.numeric' => 'Debe ingresar números válidos.',

            'enterprise.required' => 'La Empresa es requerida.',
            'enterprise.numeric' => 'Debe elegir una Empresa válida.',

            'date_admission.required' => 'La Fecha de Admisión es requerida.',
            'date_admission.date' => 'Debe ingresar una Fecha válida.'
        ];
    }
}
