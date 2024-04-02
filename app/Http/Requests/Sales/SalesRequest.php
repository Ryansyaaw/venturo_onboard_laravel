<?php

namespace App\Http\Requests\Sales;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class SalesRequest extends FormRequest
{
    public $validator;

    public function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }


    public function rules()
    {
        if ($this->isMethod('post')) {
            return $this->createRules();
        }

        return $this->updateRules();
    }

    private function createRules():array
    {
        return [
            'm_customer_id' => 'required',
            'm_voucher_id' => 'required|numeric',
            'voucher_nominal' => 'required|numeric',
            'm_discount_id' => 'required|numeric',
            'date' => 'nullable',
            'details.*.m_product_id' => 'required',
            'details.*.m_product_detail_id' => 'required',
            'details.*.total_item' => 'required',
            'details.*.price' => 'required',
            'details.*.discount_nominal' => 'numeric',
        ];
    }

    private function updateRules():array
    {
        return [
        'm_customer_id' => 'required',
        'm_voucher_id' => 'required|numeric',
        'voucher_nominal' => 'required|numeric',
        'm_discount_id' => 'required|numeric',
        'date' => 'nullable',
        'details.*.m_product_id' => 'required',
        'details.*.m_product_detail_id' => 'required',
        'details.*.total_item' => 'required',
        'details.*.price' => 'required',
        'details.*.discount_nominal' => 'numeric',
     ];
 }

}
