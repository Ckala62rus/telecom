<?php

namespace App\Repositories;

use App\Models\EquipmentType;
use Illuminate\Database\Eloquent\Builder;

class EquipmentTypeRepository extends Repository
{
    /**
     * EquipmentTypeRepository constructor.
     */
    public function __construct()
    {
        $this->model = new EquipmentType();
    }
}
