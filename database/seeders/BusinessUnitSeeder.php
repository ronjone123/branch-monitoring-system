<?php

namespace Database\Seeders;

use App\Models\BusinessUnit;
use Illuminate\Database\Seeder;

class BusinessUnitSeeder extends Seeder
{
    public function run(): void
    {
        BusinessUnit::updateOrCreate(
            ['code' => 'L4'],
            [
                'name' => 'Lucky 4',
                'description' => 'Motorcycle, Appliances, Furniture',
                'status' => 'active',
            ]
        );

        BusinessUnit::updateOrCreate(
            ['code' => 'M8'],
            [
                'name' => 'Motor 8',
                'description' => 'Motorcycle only',
                'status' => 'active',
            ]
        );
    }
}