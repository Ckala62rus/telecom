<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EquipmentTypeController extends BaseController
{
    public function __invoke(): JsonResponse
    {
        return $this->sendResponse([], "equipment-type");
    }
}
