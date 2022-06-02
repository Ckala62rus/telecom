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
}
