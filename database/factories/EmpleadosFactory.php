<?php

namespace Database\Factories;

use App\Models\Empleados;
use App\Models\Cargo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Empleados>
 */
class EmpleadosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // generamos un factory para empleados
        return [
            'nombre' => $this->faker->firstName(),
            'apellido'=> $this->faker->lastName(),
            'fecha_nacimiento'=> $this->faker->date(),
            'fecha_de_ingreso'=> $this->faker->date(),
            'salario'=> $this->faker->randomFloat(2, 1000, 10000),
            'estado'=> $this->faker->randomElement(['activo', 'inactivo']),
            'id_cargo' => Cargo::query()->inRandomOrder()->value('id') ?? Cargo::factory(),
        ];
    }
}
