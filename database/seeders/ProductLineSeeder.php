<?php

namespace Database\Seeders;

use App\Models\ProductLine;
use Illuminate\Database\Seeder;

class ProductLineSeeder extends Seeder
{
    public function run(): void
    {
        ProductLine::updateOrCreate(
            ['code' => 'MC'],
            [
                'name' => 'Motorcycle',
                'status' => 'active',
            ]
        );

        ProductLine::updateOrCreate(
            ['code' => 'APP'],
            [
                'name' => 'Appliances',
                'status' => 'active',
            ]
        );

        ProductLine::updateOrCreate(
            ['code' => 'FUR'],
            [
                'name' => 'Furniture',
                'status' => 'active',
            ]
        );
    }
}