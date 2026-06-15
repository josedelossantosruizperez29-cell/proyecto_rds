<?php

namespace Database\Seeders;

use App\Models\Cargo;
use App\Models\Empleados;
use Illuminate\Database\Seeder;

class EmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cargoIds = Cargo::query()->pluck('id');

        if ($cargoIds->isEmpty()) {
            $cargoIds = Cargo::factory()->count(40)->create()->pluck('id');
        }

        Empleados::factory()
            ->count(30)
            ->create([
                'id_cargo' => fn () => $cargoIds->random(),
            ]);
    }
}
