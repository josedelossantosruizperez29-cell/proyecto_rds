<?php

namespace Database\Factories;

use App\Models\FuncionCargo;
use App\Models\Cargo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FuncionCargo>
 */
class FuncionCargoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // generamos un factory para funciones de cargo
            'descripcion_funcion' => $this->faker->sentence(),
            'estado' => $this->faker->randomElement(['activo', 'inactivo']),
            'id_cargo'=>Cargo::factory(),
        ];
    }
}
