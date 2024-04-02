<?php
namespace App\Helpers\User;

use App\Helpers\Venturo;
use App\Models\CustomerModel;
use Illuminate\Support\Facades\Hash;
use Throwable;

/**
 * Helper untuk manajemen user
 * Mengambil data, menambah, mengubah, & menghapus ke tabel user_auth
 *
 * @author Wahyu Agung <wahyuagung26@gmail.com>
 */
class CustomerHelper extends Venturo
{
    const USER_PHOTO_DIRECTORY = 'foto-user';
    private $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
    }

    public function create(array $payload): array
    {
        try {
            $payload = $this->uploadGetPayload($payload);
            $customer = $this->customerModel->store($payload);

            return [
                'status' => true,
                'data' => $customer
            ];
        } catch (Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage()
            ];
        }
    }

    /**
     * Menghapus data user dengan sistem "Soft Delete"
     * yaitu mengisi kolom deleted_at agar data tsb tidak
     * keselect waktu menggunakan Query
     *
     * @param integer $id id dari tabel user_auth
     *
     * @return bool
     */
    public function delete(string $id): bool
    {
        try {
            $this->customerModel->drop($id);

            return true;
        } catch (Throwable $th) {
            return false;
        }
    }


    public function getAll(array $filter, int $itemPerPage = 0, string $sort = '')
    {
        $customers = $this->customerModel->getAll($filter, $itemPerPage, $sort);

        return [
            'status' => true,
            'data' => $customers
        ];
    }

    /**
     * Mengambil 1 data user dari tabel user_auth
     *
     * @param integer $id id dari tabel user_auth
     *
     * @return array
     */
    public function getById(string $id): array
    {
        $customer = $this->customerModel->getById($id);
        if (empty($customer)) {
            return [
                'status' => false,
                'data' => null
            ];
        }

        return [
            'status' => true,
            'data' => $customer
        ];
    }

    /**
     * method untuk mengubah user pada tabel user_auth
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     *
     * @param array $payload
     *                       $payload['name'] = string
     *                       $payload['email] = string
     *                       $payload['password] = string
     *
     * @return array
     */
    public function update(array $payload, String $id): array
    {
        try {
            $payload = $this->uploadGetPayload($payload);
            $this->customerModel->edit($payload, $id);

            $customer = $this->getById($id);

            return [
                'status' => true,
                'data' => $customer['data']
            ];
        } catch (Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage()
            ];
        }
    }

    /**
     * Upload file and remove payload when photo is not exist
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     *
     * @param array $payload
     * @return array
     */
    private function uploadGetPayload(array $payload)
    {
        /**
         * Jika dalam payload terdapat base64 foto, maka Upload foto ke folder public/uploads/foto-user
         */
        if (!empty($payload['photo'])) {
            $fileName = $this->generateFileName($payload['photo'], 'USER_' . date('Ymdhis'));
            $photo = $payload['photo']->storeAs(self::USER_PHOTO_DIRECTORY, $fileName, 'public');
            $payload['photo'] = $photo;
        } else {
            unset($payload['photo']);
        }

        return $payload;
    }
}
