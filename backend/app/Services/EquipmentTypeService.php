<?php

namespace App\Services;

use App\Repositories\EquipmentRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class EquipmentTypeService
{
    /**
     * @var EquipmentRepository
     */
    protected EquipmentRepository $equipmentRepository;

    /**
     * EquipmentTypeService constructor.
     * @param EquipmentRepository $equipmentRepository
     */
    public function __construct(
        EquipmentRepository $equipmentRepository
    ) {
        $this->equipmentRepository = $equipmentRepository;
    }

    /**
     * Get all equipment types with pagination
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getAllEquipmentTypeWithPagination(int $limit): LengthAwarePaginator
    {
        return  $this
            ->equipmentRepository
            ->paginateAll($limit);
    }

    /**
     * Get equipment by id
     * @param int $equipmentId
     * @return Model|null
     */
    public function getEquipmentById(int $equipmentId): ?Model
    {
        return $this
            ->equipmentRepository
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
            ->equipmentRepository
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
            ->equipmentRepository
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
            ->equipmentRepository
            ->destroy($id);
    }
}
