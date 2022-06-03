<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipmentType\EquipmentTypeAllRequest;
use App\Http\Resources\EquipmentType\EquipmentTypeAllResource;
use App\Services\EquipmentTypeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EquipmentTypeController extends BaseController
{
    /**
     * @var EquipmentTypeService
     */
    protected EquipmentTypeService $equipmentTypeService;

    /**
     * EquipmentTypeController constructor.
     * @param EquipmentTypeService $equipmentTypeService
     */
    public function __construct(
        EquipmentTypeService $equipmentTypeService
    ) {
        $this->equipmentTypeService = $equipmentTypeService;
    }

    /**
     * Get all equipment types
     * @param EquipmentTypeAllRequest $request
     * @return JsonResponse
     */
    public function __invoke(EquipmentTypeAllRequest $request): JsonResponse
    {
        $equipmentTypes = $this
            ->equipmentTypeService
            ->getAllEquipmentTypeWithPagination($request->all());

        return $this->sendResponse([
            'equipment_types' => EquipmentTypeAllResource::collection($equipmentTypes),
            'count' => $equipmentTypes->total()
        ], "equipment-type");
    }
}
