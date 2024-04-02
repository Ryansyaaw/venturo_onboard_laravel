<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Promo\PromoHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Promo\PromoRequest;
use App\Http\Resources\Promo\PromoCollection;
use App\Http\Resources\Promo\PromoResource;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    private $promo;

    public function __construct()
    {
        $this->promo = new PromoHelper();
    }

    /**
     * Delete data user
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     * @param mixed $id
     */
    public function destroy($id)
    {
        $promo = $this->promo->delete($id);

        if (!$promo) {
            return response()->failed(['Mohon maaf data promo tidak ditemukan']);
        }

        return response()->success($promo, "Data promo berhasil dihapus");
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
            'status' => $request->status ?? '',
        ];
        $promos = $this->promo->getAll($filter, 5, $request->sort ?? '');

        return response()->success(new PromoCollection($promos['data']));
    }

    /**
     * Menampilkan user secara spesifik dari tabel user_auth
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     * @param mixed $id
     */
    public function show($id)
    {
        $promo = $this->promo->getById($id);

        if (!($promo['status'])) {
            return response()->failed(['Data promo tidak ditemukan'], 404);
        }
        return response()->success(new PromoResource($promo['data']));
    }

    /**
     * Membuat data user baru & disimpan ke tabel user_auth
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function store(PromoRequest $request)
    {
        /**
         * Menampilkan pesan error ketika validasi gagal
         * pengaturan validasi bisa dilihat pada class app/Http/request/User/CreateRequest
         */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $payload = $request->only(['name', 'status', 'expired_in_day', 'photo', 'nominal_percentage','nominal_rupiah', 'term_conditions']);
        $promo = $this->promo->create($payload);

        if (!$promo['status']) {
            return response()->failed($promo['error']);
        }

        return response()->success(new PromoResource($promo['data']), "User berhasil ditambahkan");
    }

    /**
     * Mengubah data user di tabel user_auth
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function update(PromoRequest $request)
    {

        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        if (!isset($request->id)) {
            return response()->failed('ID tidak ditemukan');
        }

        $payload = $request->only(['name', 'status', 'expired_in_day', 'photo', 'nominal_percentage','nominal_rupiah', 'term_conditions']);
        $promo = $this->promo->update($payload, $request->id);

        if (!$promo['status']) {
            return response()->failed($promo['error']);
        }

        return response()->success(new promoResource($promo['data']), "User berhasil diubah");
    }
}
