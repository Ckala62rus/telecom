<?php

namespace App\Services;

use App\Repositories\EquipmentRepository;
use App\Repositories\EquipmentTypeRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class EquipmentTypeService
{
    /**
     * @var EquipmentTypeRepository
     */
    protected EquipmentTypeRepository $equipmentTypeRepository;

    /**
     * EquipmentTypeService constructor.
     * @param EquipmentTypeRepository $equipmentTypeRepository
     */
    public function __construct(
        EquipmentTypeRepository $equipmentTypeRepository
    ) {
        $this->equipmentTypeRepository = $equipmentTypeRepository;
    }

    /**
     * Get all equipment types with pagination
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getAllEquipmentTypeWithPagination(array $data): LengthAwarePaginator
    {
        return  $this
            ->equipmentTypeRepository
            ->paginateAll($data['limit']);
    }

    /**
     * Get equipment by id
     * @param int $equipmentId
     * @return Model|null
     */
    public function getEquipmentById(int $equipmentId): ?Model
    {
        return $this
            ->equipmentTypeRepository
            ->getRecord($equipmentId);
    }

    /**
     * Create new equipment type
     * @param array $data
     * @return Model
     */
    public function createEquipment(array $data): Model
    {
        return $this
            ->equipmentTypeRepository
            ->store($data);
    }

    /**
     * Update Equipment by id
     * @param array $data
     * @param int $id
     * @return Model
     */
    public function updateEquipment(array $data, int $id): Model
    {
        return $this
            ->equipmentTypeRepository
            ->update($data, $id);
    }

    /**
     * Delete equipment by id
     * @param int $id
     * @return bool
     */
    public function deleteEquipment(int $id): bool
    {
        return $this
            ->equipmentTypeRepository
            ->destroy($id);
    }
}
