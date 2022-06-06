<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_id',
        'serial_number',
        'description',
    ];

    public function types()
    {
        return $this->hasOne(EquipmentType::class, 'id', 'type_id');
    }
}
