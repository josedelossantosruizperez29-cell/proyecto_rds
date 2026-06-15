<?php

use App\Models\Cargo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

test('puede crear un empleado solo si el usuario esta autenticado', function () {
    Sanctum::actingAs(User::factory()->create());

    $cargo = Cargo::factory()->create();

    $datos = [
        'nombre' => 'jose',
        'apellido' => 'ruiz',
        'fecha_nacimiento' => '2000-01-01',
        'fecha_de_ingreso' => '2023-01-01',
        'salario' => '2500000',
        'id_cargo' => $cargo->id,
    ];

    $response = $this->postJson('/api/empleados', $datos);

    $response->assertStatus(201);

    $this->assertDatabaseHas('empleados', $datos);
});

test('no puede crear un empleado sin autenticacion', function () {
    $cargo = Cargo::factory()->create();

    $response = $this->postJson('/api/empleados', [
        'nombre' => 'jose',
        'apellido' => 'ruiz',
        'fecha_nacimiento' => '2000-01-01',
        'fecha_de_ingreso' => '2023-01-01',
        'salario' => '2500000',
        'id_cargo' => $cargo->id,
    ]);

    $response
        ->assertStatus(401)
        ->assertJsonPath('message', 'No autenticado. Debes iniciar sesion para acceder a este recurso.');
});

test('no puede crear un empleado sin nombre', function () {
    Sanctum::actingAs(User::factory()->create());

    $cargo = Cargo::factory()->create();

    $response = $this->postJson('/api/empleados', [
        'apellido' => 'ruiz',
        'fecha_nacimiento' => '2000-01-01',
        'fecha_de_ingreso' => '2023-01-01',
        'salario' => '2500000',
        'id_cargo' => $cargo->id,
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['nombre']);
});

test('no puede crear un empleado con cargo inexistente', function () {
    Sanctum::actingAs(User::factory()->create());

    $response = $this->postJson('/api/empleados', [
        'nombre' => 'jose',
        'apellido' => 'ruiz',
        'fecha_nacimiento' => '2000-01-01',
        'fecha_de_ingreso' => '2023-01-01',
        'salario' => '2500000',
        'id_cargo' => 999,
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['id_cargo']);
});
