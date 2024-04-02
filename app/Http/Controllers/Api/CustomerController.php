<?php

namespace App\Http\Controllers\Api;

use App\Helpers\User\CustomerHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CreateRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Http\Resources\User\CustomerCollection;
use App\Http\Resources\User\CustomerResource;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $customer;

    public function __construct()
    {
        $this->customer = new CustomerHelper();
    }

    /**
     * Delete data user
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     * @param mixed $id
     */
    public function destroy($id)
    {
        $customer = $this->customer->delete($id);

        if (!$customer) {
            return response()->failed(['Mohon maaf data customer tidak ditemukan']);
        }

        return response()->success($customer, "Data customer berhasil dihapus");
    }

    /**
     * Mengambil data user dilengkapi dengan pagination
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function index(Request $request)
    {
        $filter = [
            'name' => $request->name ?? '',
            'is_verifyed' => isset($request->is_verifyed) ? $request->is_verifyed : null,
            'id' => $request->id ?? '',
        ];
        $customers = $this->customer->getAll($filter, 5, $request->sort ?? '');

        return response()->success(new CustomerCollection($customers['data']));
    }

    /**
     * Menampilkan user secara spesifik dari tabel user_auth
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     * @param mixed $id
     */
    public function show($id)
    {
        $customer = $this->customer->getById($id);

        if (!($customer['status'])) {
            return response()->failed(['Data customer tidak ditemukan'], 404);
        }
        return response()->success(new CustomerResource($customer['data']));
    }

    /**
     * Membuat data user baru & disimpan ke tabel user_auth
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function store(CreateRequest $request)
    {
        /**
         * Menampilkan pesan error ketika validasi gagal
         * pengaturan validasi bisa dilihat pada class app/Http/request/User/CreateRequest
         */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $payload = $request->only(['email', 'name', 'date_of_birth', 'photo', 'phone_number', 'is_verifyed']);
        $customer = $this->customer->create($payload);

        if (!$customer['status']) {
            return response()->failed($customer['error']);
        }

        return response()->success(new CustomerResource($customer['data']), "User berhasil ditambahkan");
    }

    /**
     * Mengubah data user di tabel user_auth
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function update(UpdateRequest $request)
    {
        /**
         * Menampilkan pesan error ketika validasi gagal
         * pengaturan validasi bisa dilihat pada class app/Http/request/User/UpdateRequest
         */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $payload = $request->only(['id','email', 'name', 'date_of_birth', 'photo', 'phone_number', 'is_verifyed']);
        $customer = $this->customer->update($payload, $payload['id'] ?? 0);

        if (!$customer['status']) {
            return response()->failed($customer['error']);
        }

        return response()->success(new CustomerResource($customer['data']), "User berhasil diubah");
    }
}
