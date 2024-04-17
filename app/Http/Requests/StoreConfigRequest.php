<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConfigRequest extends FormRequest
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
            'max_amount_request' => 'numeric|min:0',
            'max_percent_request' => 'numeric|min:0|max:100'
        ];
    }

    public function messages()
    {
        return [
            'max_amount_request.numeric' => 'El monto debe de ser un número.',
            'max_amount_request.min' => 'El monto debe de ser mínimo de 0.',
            
            'max_percent_request.numeric' => 'El porcentaje debe de ser un número.',
            'max_percent_request.min' => 'El porcentaje debe de ser mínimo de 0%.',
            'max_percent_request.max' => 'El porcentaje es de máximo 100%.'
        ];
    }
}
