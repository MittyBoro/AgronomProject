<?php

namespace Database\Seeders;

use App\Models\VariationGroup;
use Illuminate\Database\Seeder;

class VariationGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        VariationGroup::factory(10)->create();
    }
}
