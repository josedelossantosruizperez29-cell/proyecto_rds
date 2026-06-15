<?php

use App\Models\Cargo;
use App\Models\Empleados;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

test('puede actualizar un empleado solo si el usuario esta autenticado', function () {
    Sanctum::actingAs(User::factory()->create());

    $cargo = Cargo::factory()->create();

    $datos = [
        'nombre' => 'jose_actualizado',
        'apellido' => 'ruiz_actualizado',
    ];

    $empleado = Empleados::factory()->create([
        'id_cargo' => $cargo->id,
    ]);

    $response = $this->putJson("/api/empleados/{$empleado->id}", $datos);

    $response->assertStatus(200);

    $this->assertDatabaseHas('empleados', $datos);
});

test('no puede actualizar un empleado sin autenticacion', function () {
    $cargo = Cargo::factory()->create();

    $empleado = Empleados::factory()->create([
        'id_cargo' => $cargo->id,
    ]);

    $response = $this->putJson("/api/empleados/{$empleado->id}", [
        'nombre' => 'jose_actualizado',
    ]);

    $response
        ->assertStatus(401)
        ->assertJsonPath('message', 'No autenticado. Debes iniciar sesion para acceder a este recurso.');
});

test('no puede actualizar un empleado con cargo inexistente', function () {
    Sanctum::actingAs(User::factory()->create());

    $cargo = Cargo::factory()->create();

    $empleado = Empleados::factory()->create([
        'id_cargo' => $cargo->id,
    ]);

    $response = $this->putJson("/api/empleados/{$empleado->id}", [
        'id_cargo' => 999,
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['id_cargo']);
});
