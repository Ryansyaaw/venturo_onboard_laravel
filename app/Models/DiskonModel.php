<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiskonModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $timestamps = true;

    protected $fillable = [
        'status',
        'm_customer_id',
        'm_promo_id'
    ];

    protected $casts = [
        'id' => 'string',
    ];

    protected $table = 'm_diskon';

    public function customer()
{
  return $this->belongsTo(CustomerModel::class, 'm_customer_id', 'id');
}

public function promo()
{
  return $this->belongsTo(PromoModel::class, 'm_promo_id', 'id');
}

public function drop(int $id)
{
  return $this->find($id)->delete();
}

public function edit(array $payload, int $id)
{
  return $this->find($id)->update($payload);
}

public function store(array $payload)
{
  return $this->create($payload);
}

public function getAll(array $filter, int $itemPerPage = 0, string $sort = '')
{
  $user = $this->query();

  if (!empty($filter['m_customer_id']) && is_array($filter['m_customer_id'])) {
      $user->whereIn('m_customer_id', $filter['m_customer_id']);
  }
  if ($filter['status'] != '') {
    $user->where('status', '=', $filter['status']);
 }

  $sort = $sort ?: 'id DESC';
  $user->orderByRaw($sort);
  $itemPerPage = ($itemPerPage > 0) ? $itemPerPage : false;

  return $user->paginate($itemPerPage)->appends('sort', $sort);
}

public function getById(int $id)
{
  return $this->find($id);
}

}
