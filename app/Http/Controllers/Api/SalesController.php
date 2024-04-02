<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Sales\SalesHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sales\SalesRequest;
use App\Http\Resources\Sales\SalesCollection;
use App\Http\Resources\Sales\SalesResource;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    private $product;
    public function __construct()
    {
       $this->product = new SalesHelper();
    }

    public function destroy($id)
    {
       $product = $this->product->delete($id);

       if (!$product['status']) {
           return response()->failed(['Mohon maaf product tidak ditemukan']);
       }

       return response()->success($product, 'product berhasil dihapus');
    }

    public function index(Request $request)
    {
       $filter = [
           'name' => $request->name ?? '',
           'm_product_category_id' => $request->product_category_id ?? '',
           'is_available' => isset($request->is_available) ? $request->is_available : '',
       ];
       $products = $this->product->getAll($filter, $request->per_page ?? 25, $request->sort ?? '');

       return response()->success(new SalesCollection($products['data']));
    }

    public function show($id)
    {
       $product = $this->product->getById($id);

       if (!($product['status'])) {
           return response()->failed(['Data product tidak ditemukan'], 404);
       }

       return response()->success(new SalesResource($product['data']));
    }

    public function store(SalesRequest $request)
    {
       if (isset($request->validator) && $request->validator->fails()) {
           return response()->failed($request->validator->errors());
       }

       $payload = $request->only([
           'm_customer_id',
           'm_voucher_id',
           'voucher_nominal',
           'm_discount_id',
           'date',
           'details',
       ]);

       $product = $this->product->create($payload);

       if (!$product['status']) {
           return response()->failed($product['error']);
       }

       return response()->success(new SalesResource($product['data']), 'product berhasil ditambahkan');
    }

    public function update(SalesRequest $request)
    {
       if (isset($request->validator) && $request->validator->fails()) {
           return response()->failed($request->validator->errors());
       }

       $payload = $request->only([
        'id',
        'm_customer_id',
        'm_voucher_id',
        'voucher_nominal',
        'm_discount_id',
        'date',
        'details',
       ]);

       $product = $this->product->update($payload, $payload['id'] ?? 0);

       if (!$product['status']) {
           return response()->failed($product['error']);
       }

       return response()->success(new SalesResource($product['data']), 'product berhasil diubah');
    }


}
