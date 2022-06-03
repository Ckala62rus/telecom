<?php

namespace App\Repositories;

use App\Models\Equipment;
use Illuminate\Database\Eloquent\Builder;

class EquipmentRepository extends Repository
{
    /**
     * EquipmentTypeRepository constructor.
     */
    public function __construct()
    {
        $this->model = new Equipment();
    }

    /**
     * @param Builder $query
     * @param string $sn
     * @return Builder
     */
    public function getEquipmentBySn(Builder $query, string $sn): Builder
    {
        return $query->where('serial_number', $sn);
    }
}
