<?php

namespace App\Http\Controllers;

use App\Http\Requests\Equipment\EquipmentAllRequest;
use App\Http\Requests\Equipment\EquipmentCreateRequest;
use App\Http\Requests\Equipment\EquipmentUpdateRequest;
use App\Http\Resources\Equipment\EquipmentAllResource;
use App\Services\EquipmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EquipmentController extends BaseController
{
    /**
     * @var EquipmentService
     */
    protected EquipmentService $equipmentService;

    /**
     * @param EquipmentService $equipmentService
     */
    public function __construct(EquipmentService $equipmentService)
    {
        $this->equipmentService = $equipmentService;
    }

    /**
     * @param EquipmentAllRequest $request
     * @return JsonResponse
     */
    public function index(EquipmentAllRequest $request): JsonResponse
    {
        $equipment = $this
            ->equipmentService
            ->getAllEquipment($request->all());

        return $this->sendResponse([
            'equipment' => EquipmentAllResource::collection($equipment),
            'count' => $equipment->total()
        ], "index");
    }

    /**
     * Create equipments
     * @param EquipmentCreateRequest $request
     * @return JsonResponse
     */
    public function store(EquipmentCreateRequest $request): JsonResponse
    {
        $out = $this
            ->equipmentService
            ->createEquipment(($request->all())['equipments']);

        if (!count($out)) {
            return $this->sendResponse([], "created equipment success");
        }

        return $this->sendError("validate fail or exist in db", $out->toArray(), 200);
    }

    /**
     * Get equipment by id
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $equipment = $this
            ->equipmentService
            ->getEquipmentById($id);

        if ($equipment) {
            return $this->sendResponse([
                'equipment' => EquipmentAllResource::make($equipment)
            ], "get by id=" . $id);
        }

        return $this->sendError("equipment by id=" . $id ." not found", [], 404);
    }

    /**
     * Update equipment by id
     * @param EquipmentUpdateRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(EquipmentUpdateRequest $request, $id): JsonResponse
    {
        $equipment = $this
            ->equipmentService
            ->updateEquipmentById($request->all(), $id);

        if (!$equipment) {
            return $this->sendError("validate fail or exist in db", [], 200);
        }

        return $this->sendResponse([
            'equipment' => EquipmentAllResource::make($equipment)
        ], "update by it");
    }

    /**
     * Delete equipment by id
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $isDelete = $this
            ->equipmentService
            ->deleteEquipmentById($id);

        if ($isDelete) {
            return $this->sendResponse([], "delete equipment by id=" . $id . " success");
        }

        return $this->sendError("equipment by id=" . $id . " not found", [], 404);
    }
}
