<?php

namespace Database\Factories;

use App\Models\cargo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Sanctum\HasApiTokens;

/**
 * @extends Factory<cargo>
 */
class CargoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    use HasApiTokens;
    public function definition(): array
    {
        // crearemos un factory para cargos asi se podra crear un empleado con un cargo
        return [
            'nombre_cargo' => $this->faker->jobTitle(),
            'descripcion' => $this->faker->sentence()
        ];
    }
}
