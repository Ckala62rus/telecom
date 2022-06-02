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
        EquipmentType::create(['name_type'=>'TP-Link TL-WR74', 'mask_sn' => 'XXAAAAAXAA']);
        EquipmentType::create(['name_type'=>'D-Link DIR-300', 'mask_sn' => 'NXXAAXZXaa']);
        EquipmentType::create(['name_type'=>'D-Link DIR-300 S', 'mask_sn' => 'NXXAAXZXaa']);
    }
}
