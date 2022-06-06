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

    /**
     * Get relation
     * @param Builder $query
     * @param string $with
     * @return Builder
     */
    public function getWithEquipmentType(Builder $query, string $with): Builder
    {
        return $query->with($with);
    }

    /**
     * Find by serial number
     * @param Builder $query
     * @param $sn
     * @return Builder
     */
    public function findBySerialNumber(Builder $query, $sn): Builder
    {
        return $query->where('serial_number', 'LIKE' ,'%' . $sn . '%');
    }

    /**
     * Find by description
     * @param Builder $query
     * @param $description
     * @return Builder
     */
    public function findByDescription(Builder $query, $description): Builder
    {
        return $query->where('description', 'LIKE' ,'%' . $description . '%');
    }
}
