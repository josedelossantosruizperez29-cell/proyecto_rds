<?php

namespace Database\Seeders;
use App\Models\FuncionCargo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FuncionCargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FuncionCargo::factory(10)->create();
    }
}
