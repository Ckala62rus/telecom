<?php

namespace App\Http\Controllers;

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
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $equipmentTypes = $this
            ->equipmentTypeService
            ->getAllEquipmentTypeWithPagination($request->limit);

        return $this->sendResponse([$equipmentTypes], "equipment-type");
    }
}
