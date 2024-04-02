<?php

namespace App\Http\Requests\Promo;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
{
    public $validator;

    public function failedValidation(Validator $validator)
    {
    $this->validator = $validator;
    }


    public function rules() :array
    {
    if ($this->isMethod('post')) {
        return $this->createRules();
    }

    return $this->updateRules();
    }

        private function createRules():array
    {
    return [
        'customer_id' => 'required',
        'promo_id' => 'required|numeric',
        'start_time' => 'required',
        'end_time' => 'required',
        'total_voucher' => 'required|numeric',
        'nominal_rupiah' => 'required|numeric',
        ];
    }

        private function updateRules():array
    {
    return [
        'id' => 'required|numeric',
        'customer_id' => 'required',
        'promo_id' => 'required|numeric',
        'start_time' => 'required',
        'end_time' => 'required',
        'total_voucher' => 'required|numeric',
        'nominal_rupiah' => 'required|numeric',
    ];
    }


    public function attributes()
    {
    return [
        'customer_id' => 'Customer',
        'promo_id' => 'Voucher',
        'nominal_rupiah' => 'Nominal',
    ];
    }
}
