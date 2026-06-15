<?php

namespace Database\Seeders;

use App\Models\Cargo;
use App\Models\FuncionCargo;
use Illuminate\Database\Seeder;

class FuncionCargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cargo::all()->each(function (Cargo $cargo): void {
            FuncionCargo::factory()
                ->count(5)
                ->create([
                    'id_cargo' => $cargo->id,
                ]);
        });
    }
}
