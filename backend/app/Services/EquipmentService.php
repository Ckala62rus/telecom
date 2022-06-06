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
        $bySerialNumber = $this->findBySerialNumber($data);

        if (count($bySerialNumber) > 0) {
            return $bySerialNumber;
        }

        return $this->findByDescription($data);
    }

    /**
     * Find By serial Number
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function findBySerialNumber(array $data): LengthAwarePaginator
    {
        $query = $this
            ->equipmentRepository
            ->query();

        $query = $this
            ->equipmentRepository
            ->getWithEquipmentType($query, 'types');

        if (!empty($data['query'])) {
            $query = $this
                ->equipmentRepository
                ->findBySerialNumber($query, $data['query']);
        }

        return $query->paginate($data['limit']);
    }

    /**
     * Find by description
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function findByDescription(array $data): LengthAwarePaginator
    {
        $query = $this
            ->equipmentRepository
            ->query();

        $query = $this
            ->equipmentRepository
            ->getWithEquipmentType($query, 'types');

        $query = $this
            ->equipmentRepository
            ->findByDescription($query, $data['query']);

        return $query->paginate($data['limit']);
    }

    public function createEquipment(array $data): Collection
    {
        $equipmentType = $this
            ->equipmentTypeService
            ->getEquipmentById($data['type_id']);

        $errorModel = collect();

        foreach ($data['equipments'] as $equipment) {
            if (preg_match('/' . $equipmentType['reg'] . '/', $equipment['serial_number']))
            {
                if (!$this->isExistSerialNumber($equipment['serial_number']))
                {
                    $this->equipmentRepository->store([
                        'type_id' => $data['type_id'],
                        'serial_number' => $equipment['serial_number'],
                        'description' => $equipment['description'] ?? '',
                    ]);
                } else {
                    $errorModel->push(['equipment' => $equipment, 'error' => 'serial number exist in database']);
                }
            } else {
                $errorModel->push(['equipment' => $equipment, 'error' => 'invalid reg expression']);
            }
        }

        return $errorModel;
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

    /**
     * Update equipment by id
     * @param array $data
     * @param int $id
     * @return Collection
     */
    public function updateEquipmentById(array $data, int $id): Collection
    {
        $equipmentType = $this
            ->equipmentTypeRepository
            ->getRecord($data['type_id']);

        $errorModel = collect();

            if (preg_match('/' . $equipmentType['reg'] . '/', $data['serial_number']))
            {
                $this
                    ->equipmentRepository
                    ->update([
                        'serial_number' => $data['serial_number'],
                        'description' => $data['description'] ?? '',
                    ], $id);
            } else {
                $errorModel->push(['equipment' => $data, 'error' => 'invalid reg expression']);
            }

        return $errorModel;
    }
}
