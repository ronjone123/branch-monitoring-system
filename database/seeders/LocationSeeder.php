<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            ['code' => 'MBL', 'name' => 'Marbel'],
            ['code' => 'DGS', 'name' => 'Digos'],
            ['code' => 'GSC', 'name' => 'Gensan'],
            ['code' => 'SUR', 'name' => 'Surallah'],
            ['code' => 'ISK', 'name' => 'Isulan'],
            ['code' => 'TSK', 'name' => 'Tacurong'],
            ['code' => 'KLM', 'name' => 'Kulaman'],
            ['code' => 'GLN', 'name' => 'Glan'],
            ['code' => 'CPG', 'name' => 'Calumpang'],
        ];

        foreach ($locations as $location) {
            Location::updateOrCreate(
                ['code' => $location['code']],
                [
                    'name' => $location['name'],
                    'status' => 'active',
                ]
            );
        }
    }
}