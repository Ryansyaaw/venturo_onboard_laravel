<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Promo\DiskonHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Promo\DiskonRequest;
use App\Http\Resources\Promo\DiskonCollection;
use App\Http\Resources\Promo\DiskonResource;
use Illuminate\Http\Request;

class DiskonController extends Controller
{

private $diskon;
public function __construct()
{
  $this->diskon = new DiskonHelper();
}

public function destroy($id)
{
  $diskon = $this->diskon->delete($id);

  if (!$diskon) {
      return response()->failed(['Mohon maaf voucher tidak ditemukan']);
  }

  return response()->success($diskon, 'voucher berhasil dihapus');
}

public function index(Request $request)
{
  $filter = [
    'm_customer_id' => isset($request->customer_id) ? explode(',', $request->customer_id) : [],
    'status' => isset($request->status) ? $request->status : null,
  ];
  $categories = $this->diskon->getAll($filter, $request->per_page ?? 25, $request->sort ?? '');

  return response()->success(new DiskonCollection($categories['data']));
}

public function show($id)
{
  $diskon = $this->diskon->getById($id);

  if (!($diskon['status'])) {
      return response()->failed(['Data voucher tidak ditemukan'], 404);
  }

  return response()->success(new DiskonResource($diskon['data']));
}

public function store(DiskonRequest $request)
{
  if (isset($request->validator) && $request->validator->fails()) {
      return response()->failed($request->validator->errors());
  }

  $payload = $request->only(['customer_id', 'promo_id', 'status']);
  $payload = $this->renamePayload($payload);
  $diskon = $this->diskon->create($payload);

  if (!$diskon['status']) {
      return response()->failed($diskon['error']);
  }

  return response()->success(new DiskonResource($diskon['data']), 'voucher berhasil ditambahkan');
}

public function update(DiskonRequest $request)
{
  if (isset($request->validator) && $request->validator->fails()) {
      return response()->failed($request->validator->errors());
  }

  $payload = $request->only(['id','customer_id', 'promo_id', 'status']);
  $payload = $this->renamePayload($payload);
  $diskon = $this->diskon->update($payload, $payload['id'] ?? 0);

  if (!$diskon['status']) {
      return response()->failed($diskon['error']);
  }

  return response()->success(new DiskonResource($diskon['data']), 'voucher berhasil diubah');
}


public function renamePayload($payload) {
    $payload['m_customer_id'] = $payload['customer_id'] ?? null;
    $payload['m_promo_id'] = $payload['promo_id'] ?? null;
    unset($payload['customer_id']);
    unset($payload['promo_id']);
    return $payload;
  }

}
