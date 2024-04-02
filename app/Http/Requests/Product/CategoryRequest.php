<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;


class CategoryRequest extends FormRequest
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
private function createRules() :array
{
   return [
       'name' => 'required|max:150',
   ];
}
private function updateRules() :array
{
   return [
       'name' => 'required|max:150',
       'id' => 'required'
   ];
}
}
