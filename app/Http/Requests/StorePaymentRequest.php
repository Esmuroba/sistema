<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
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
            'payment_id' => 'required|numeric',
            'liquidation_date' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'payment_id.required' => 'El Id del pago es requerido.',
            'payment_id.numeric' => 'Debe de ser un Id de pago válido.',

            'liquidation_date.required' => 'La fecha del pago es requerida.'
        ];
    }
}
