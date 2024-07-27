<?php

namespace Database\Seeders;

use App\Enums\VariationGroupTypeEnum;
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
        VariationGroup::create([
            'type' => VariationGroupTypeEnum::String->value,
            'title' => 'Объем',
        ]);
        VariationGroup::create([
            'type' => VariationGroupTypeEnum::String->value,
            'title' => 'Вес',
        ]);
    }
}
