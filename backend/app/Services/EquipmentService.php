<?php

namespace App\Services;

use App\Repositories\EquipmentRepository;
use App\Repositories\EquipmentTypeRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EquipmentService
{
    /**
     * @var EquipmentRepository
     */
    protected EquipmentRepository $equipmentRepository;

    /**
     * @var EquipmentTypeRepository
     */
    protected EquipmentTypeRepository $equipmentTypeRepository;

    /**
     * @var EquipmentTypeService
     */
    protected EquipmentTypeService $equipmentTypeService;


    /**
     * @param EquipmentRepository $equipmentRepository
     * @param EquipmentTypeRepository $equipmentTypeRepository
     * @param EquipmentTypeService $equipmentTypeService
     */
    public function __construct(
        EquipmentRepository $equipmentRepository,
        EquipmentTypeRepository $equipmentTypeRepository,
        EquipmentTypeService $equipmentTypeService
    ) {
        $this->equipmentRepository = $equipmentRepository;
        $this->equipmentTypeRepository = $equipmentTypeRepository;
        $this->equipmentTypeService = $equipmentTypeService;
    }

    /**
     * Get all equipment
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getAllEquipment(array $data): LengthAwarePaginator
    {
        return $this
            ->equipmentRepository
            ->paginateAll($data['limit']);
    }

    public function createEquipment(array $equipments): Collection
    {
        $equipmentTypes = $this
            ->equipmentTypeRepository
            ->all();

        $createdModels = collect();
        $inputModels = collect();

        $this->inputSerialNumbers($inputModels, $equipments);

        foreach ($equipments as $equipment) {
            foreach ($equipmentTypes as $type) {
                if (
                    preg_match('/' . $type['reg'] . '/', $equipment['serial_number'])
                    && !$this->isExistSerialNumber($equipment['serial_number'])
                )
                {
                    $model = $this->equipmentRepository->store([
                        'type_id' => $type['id'],
                        'serial_number' => $equipment['serial_number'],
                        'description' => $equipment['description'] ?? '',
                    ]);
                    $createdModels->push($model->serial_number);
                    break;
                }
            }
        }

        return $inputModels->diff($createdModels);
    }

    /**
     * Prepare input serial numbers
     * @param $inputModels
     * @param $equipments
     * @return void
     */
    public function inputSerialNumbers($inputModels, $equipments): void
    {
        foreach ($equipments as $equipment)
        {
            $inputModels->push($equipment["serial_number"]);
        }
    }

    /**
     * Return bool if exist model in database
     * @param string $sn
     * @return bool
     */
    public function isExistSerialNumber(string $sn): bool
    {
        $query = $this
            ->equipmentRepository
            ->query();

        $query = $this
            ->equipmentRepository
            ->getEquipmentBySn($query, $sn);

        return (bool)$query->first();
    }

    /**
     * Find equipment by id
     * @param int $id
     * @return Model|null
     */
    public function getEquipmentById(int $id): ?Model
    {
        return $this
            ->equipmentRepository
            ->getRecordWithoutException($id);
    }

    /**
     * Delete equipment by id
     * @param int $id
     * @return bool
     */
    public function deleteEquipmentById(int $id): bool
    {
        return $this
            ->equipmentRepository
            ->destroy($id);
    }
}
