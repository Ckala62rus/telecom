<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquipmentController extends BaseController
{

    public function index()
    {
        return $this->sendResponse([], "index");
    }

    public function store(Request $request)
    {
        return $this->sendResponse([], "store");
    }

    public function show($id)
    {
        return $this->sendResponse([], "get by id");
    }

    public function update(Request $request, $id)
    {
        return $this->sendResponse([], "update by it");
    }

    public function destroy($id)
    {
        return $this->sendResponse([], "delete by id");
    }
}
