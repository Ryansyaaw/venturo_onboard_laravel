<?php
namespace App\Helpers\Promo;

use App\Helpers\Venturo;
use App\Models\DiskonModel;
use Illuminate\Support\Facades\Hash;
use Throwable;

class DiskonHelper extends Venturo
{
    const PRODUCT_PHOTO_DIRECTORY = 'foto-promo';
private $promo;

public function __construct()
{
   $this->promo = new DiskonModel();
}

public function create(array $payload): array
{
   try {

       $promo = $this->promo->store($payload);


       return [
           'status' => true,
           'data' => $promo
       ];
   } catch (Throwable $th) {
       $this->rollbackTransaction();

       return [
           'status' => false,
           'error' => $th->getMessage()
       ];
   }
}
public function delete(string $id): bool
{
    try {
        $this->promo->drop($id);

        return true;
    } catch (Throwable $th) {
        return false;
    }
}
public function getAll(array $filter, int $itemPerPage = 0, string $sort = '')
{
   $promo = $this->promo->getAll($filter, $itemPerPage, $sort);

   return [
       'status' => true,
       'data' => $promo
   ];
}


public function getById(int $id): array
{
   $promo = $this->promo->getById($id);
   if (empty($promo)) {
       return [
           'status' => false,
           'data' => null
       ];
   }

   return [
       'status' => true,
       'data' => $promo
   ];
}
public function update(array $payload, String $id): array
{
    try {
        $this->promo->edit($payload, $id);

        $promo = $this->getById($id);

        return [
            'status' => true,
            'data' => $promo['data']
        ];
    } catch (Throwable $th) {
        return [
            'status' => false,
            'error' => $th->getMessage()
        ];
    }
}
}
