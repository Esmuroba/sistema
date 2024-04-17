<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePayrollRequest extends FormRequest
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
            // 'request_days' => 'required|numeric',
            'period_start_date' => 'required|date',
            'period_end_date' => 'required|date',
            'request_amount' => 'required|numeric',
            'comission' => 'required|numeric',
            'tax' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'payment_date' => 'required|date',
            // 'available_days' => 'required|numeric',
            'apply_until' => 'required|date',
            'notice_privacy' => 'required',
            'salary_retention' => 'required'
        ];
    }
}
