<?php

namespace App\Http\Resources\Promo;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class VoucherResource extends JsonResource
{
        public function toArray($request)
    {
    return [
        'id' => $this->id,
        'customer_id' => $this->customer->id ?? null,
        'customer_name' => $this->customer->name ?? null,
        'promo_id' => $this->promo->id ?? null,
        'promo_name' => $this->promo->name ?? null,
        'start_time' => $this->start_time,
        'end_time' => $this->end_time,
        'total_voucher' => $this->total_voucher,
        'nominal_rupiah' => $this->nominal_rupiah,
        'description' => $this->description,
        'photo' => $this->photo,
        'photo_url' => !empty($this->photo) ? Storage::disk('public')->url($this->photo) : Storage::disk('public')->url('../assets/img/no-image.png'),
    ];
    }
}
