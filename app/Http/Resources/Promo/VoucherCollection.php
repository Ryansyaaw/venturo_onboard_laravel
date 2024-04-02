<?php

namespace App\Http\Resources\Promo;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VoucherCollection extends ResourceCollection
{
    public function toArray($request)
    {
      return [
          'list' => $this->collection,
          'meta' => [
              'links' => $this->getUrlRange(1, $this->lastPage()),
              'total' => $this->total()
          ]
      ];
    }
}
