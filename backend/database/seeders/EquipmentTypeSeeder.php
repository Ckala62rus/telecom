<?php

namespace Database\Seeders;

use App\Models\EquipmentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EquipmentType::create([
            'name_type'=>'TP-Link TL-WR74',
            'mask_sn' => 'XXAAAAAXAA',
            'reg' => '^[A-Za-z0-9]{1,2}[A-Za-z]{5}[A-Za-z0-9]{1}[A-Za-z]{2}$',
        ]);
        EquipmentType::create([
            'name_type'=>'D-Link DIR-300',
            'mask_sn' => 'NXXAAXZXaa',
            'reg' => '^[0-9]{1}[A-Za-z0-9]{2}[A-Za-z]{2}[0-9]{1}(@|-|_)[0-9]{1}[a-z]{2}$',
        ]);
        EquipmentType::create([
            'name_type'=>'D-Link DIR-300 S',
            'mask_sn' => 'NXXAAXZXXX',
            'reg' => '^[0-9]{1}[A-Za-z0-9]{2}[A-Za-z]{2}[A-Za-z0-9]{1}(@|-|_)[A-Z0-9]{3}$',
        ]);
    }
}
