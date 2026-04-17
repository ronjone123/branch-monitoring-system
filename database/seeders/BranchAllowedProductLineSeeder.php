<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\ProductLine;
use Illuminate\Database\Seeder;

class BranchAllowedProductLineSeeder extends Seeder
{
    public function run(): void
    {
        $motorcycle = ProductLine::where('code', 'MC')->first();
        $appliances = ProductLine::where('code', 'APP')->first();
        $furniture = ProductLine::where('code', 'FUR')->first();

        $l4Branches = Branch::whereHas('businessUnit', function ($query) {
            $query->where('code', 'L4');
        })->get();

        $m8Branches = Branch::whereHas('businessUnit', function ($query) {
            $query->where('code', 'M8');
        })->get();

        foreach ($l4Branches as $branch) {
            $branch->productLines()->syncWithoutDetaching([
                $motorcycle?->id,
                $appliances?->id,
                $furniture?->id,
            ]);
        }

        foreach ($m8Branches as $branch) {
            $branch->productLines()->syncWithoutDetaching([
                $motorcycle?->id,
            ]);
        }
    }
}