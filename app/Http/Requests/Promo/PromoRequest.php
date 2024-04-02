<?php

namespace App\Http\Requests\Promo;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use ProtoneMedia\LaravelMixins\Request\ConvertsBase64ToFiles;

class PromoRequest extends FormRequest
{
    use ConvertsBase64ToFiles;
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


   protected function base64FileKeys():array
   {
       return [
           'photo' => 'foto-promo.jpg',
       ];
   }

   private function createRules():array
   {
       return [
           'name' => 'required|max:150',
           'status' => 'required|in:voucher,diskon',
           'expired_in_day' => 'required|numeric',
           'nominal_percentage' => 'nullable',
           'nominal_rupiah' => 'nullable',
           'term_conditions' => 'required',
           'photo' => 'nullable|file|image',
       ];
   }

   private function updateRules():array
   {
       return [
        'name' => 'required|max:150',
        'status' => 'required|in:voucher,diskon',
        'expired_in_day' => 'required|numeric',
        'nominal_percentage' => 'nullable',
        'nominal_rupiah' => 'nullable',
        'term_conditions' => 'required',
        'photo' => 'nullable|file|image',
    ];
}

}
