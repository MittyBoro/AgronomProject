<?php

namespace Database\Seeders;

use App\Enums\VariationTypeEnum;
use App\Models\Variation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VariationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Variation::create([
            'type' => VariationTypeEnum::String->value,
            'name' => 'Объем',
        ]);
        Variation::create([
            'type' => VariationTypeEnum::String->value,
            'name' => 'Вес',
        ]);
    }
}
