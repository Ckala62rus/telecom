<?php

namespace App\Http\Requests\Equipment;

use Illuminate\Foundation\Http\FormRequest;

class EquipmentCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'equipments' => 'required|array',
            'equipments.*.serial_number' => 'required|string',
            'equipments.*.description' => 'sometimes|string',
            'description' => 'string',
        ];
    }
}
