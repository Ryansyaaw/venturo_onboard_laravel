<?php

namespace App\Http\Resources\Sales;

use App\Http\Resources\Product\ProductDetailResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesResource extends JsonResource
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
            'm_customer_id' => $this->m_customer_id,
            'm_voucher_id' => $this->m_voucher_id,
            'voucher_nominal' => $this->voucher_nominal,
            'm_diskon_id' => $this->m_diskon_id,
            'date' => $this->date,
            'details' => ProductDetailResource::collection($this->details),
        ];
    }
}
