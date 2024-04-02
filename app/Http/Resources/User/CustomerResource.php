<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'photo_url' => !empty($this->photo) ? Storage::disk('public')->url($this->photo) : null,
            'phone_number' => $this->phone_number,
            'date_of_birth' => $this->date_of_birth,
            'is_verifyed' => (string) $this->is_verifyed,
        ];
    }
}
