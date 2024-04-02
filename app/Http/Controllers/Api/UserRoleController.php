<?php

namespace App\Http\Controllers\Api;

use App\Helpers\User\UserRoleHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRole\CreateRequest;
use App\Http\Requests\UserRole\UpdateRequest;
use App\Http\Resources\User\UserRoleCollection;
use App\Http\Resources\User\UserRoleResource;

class UserRoleController extends Controller
{
    private $role;

    public function __construct()
    {
        $this->role = new UserRoleHelper();
    }


    /**
    * Mengambil list user
    *
    * @author Wahyu Agung <wahyuagung26@email.com>
    */
    public function index(Request $request)
    {
    $filter = [
        'nama' => $request->nama ?? '',
    ];
    $role = $this->role->getAll($filter, 5, $request->sort ?? '');

    return response()->success(new UserRoleCollection($role['data']));
    }


    /**
    * Menampilkan user secara spesifik dari tabel user_auth
    *
    * @author Wahyu Agung <wahyuagung26@email.com>
    */
    public function show($id)
    {
    $role = $this->role->getById($id);

    if (!($role['status'])) {
        return response()->failed(['Data user tidak ditemukan'], 404);
    }

    return response()->success($role['data']);
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

    $payload = $request->only(['name', 'access']);
    $role = $this->role->create($payload);

    if (!$role['status']) {
        return response()->failed($role['error']);
    }

    return response()->success($role['data']);
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

    $payload = $request->only(['name', 'access','id']);
    $role = $this->role->update($payload, $payload['id']??0);

    if (!$role['status']) {
        return response()->failed($role['error']);
    }

    return response()->success($role['data']);
    }

        /**
    * Soft delete data user
    *
    * @author Wahyu Agung <wahyuagung26@email.com>
    * @param mixed $id
    */
    public function destroy($id)
    {
    $role = $this->role->delete($id);

    if (!$role) {
        return response()->failed(['Mohon maaf data pengguna tidak ditemukan']);
    }

    return response()->success($role);
    }
}
