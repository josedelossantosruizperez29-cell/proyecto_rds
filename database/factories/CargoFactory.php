<?php

namespace Database\Factories;

use App\Models\Cargo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cargo>
 */
class CargoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // generamos datos falsos para cargos
        return [
            'nombre_cargo' => $this->faker->jobTitle(),
            'descripcion' => $this->faker->sentence()
        ];
    }
}
