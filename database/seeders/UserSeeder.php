<?php

namespace Database\Seeders;

use App\Models\Loyalty;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'id' => 1,
            'name' => 'Dima Boro',
            'first_name' => 'Дмитрий',
            'last_name' => 'Бородин',
            'email' => 'iboro770@gmail.com',
            'password' =>
                '$2y$12$iDrXeh6vIU.Px3fYkCw7FOgXUPNgTaOiRf8p03RwPwjYTsSBGd1Ea',
            'role' => 'admin',
        ]);

        User::factory(20)->create();

        $loyalty = Loyalty::orderBy('percent', 'asc')->first();
        if ($loyalty) {
            User::query()->update(['loyalty_id' => $loyalty->id]);
        }
    }
}
