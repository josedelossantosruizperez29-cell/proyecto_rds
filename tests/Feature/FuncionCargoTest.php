<?php

use App\Models\Cargo;
use App\Models\FuncionCargo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

test('listar funciones cargo', function () {
    Sanctum::actingAs(User::factory()->create());

    FuncionCargo::factory()->count(3)->create();

    $response = $this->getJson('/api/funcionCargos');

    $response->assertStatus(200);
});

test('no puede listar funciones sin autenticacion', function () {
    $response = $this->getJson('/api/funcionCargos');

    $response
        ->assertStatus(401)
        ->assertJsonPath('message', 'No autenticado. Debes iniciar sesion para acceder a este recurso.');
});

test('crear funcion cargo', function () {
    Sanctum::actingAs(User::factory()->create());

    $cargo = Cargo::factory()->create();

    $datos = [
        'descripcion_funcion' => 'Gestionar la base de datos',
        'estado' => 'activo',
        'id_cargo' => $cargo->id,
    ];

    $response = $this->postJson('/api/funcionCargos', $datos);

    $response->assertStatus(201);

    $this->assertDatabaseHas('funcioCargo', [
        'descripcion_funcion' => 'Gestionar la base de datos',
        'id_cargo' => $cargo->id,
    ]);
});

test('mostrar funcion cargo', function () {
    Sanctum::actingAs(User::factory()->create());

    $funcion = FuncionCargo::factory()->create();

    $response = $this->getJson("/api/funcionCargos/{$funcion->id}");

    $response->assertStatus(200);

    $response->assertJson([
        'id' => $funcion->id,
        'descripcion_funcion' => $funcion->descripcion_funcion,
    ]);
});

test('actualizar funcion cargo', function () {
    Sanctum::actingAs(User::factory()->create());

    $funcion = FuncionCargo::factory()->create();

    $datosActualizados = [
        'descripcion_funcion' => 'Administrar servidores',
        'estado' => 'inactivo',
        'id_cargo' => $funcion->id_cargo,
    ];

    $response = $this->putJson(
        "/api/funcionCargos/{$funcion->id}",
        $datosActualizados
    );

    $response->assertStatus(200);

    $this->assertDatabaseHas('funcioCargo', [
        'id' => $funcion->id,
        'descripcion_funcion' => 'Administrar servidores',
        'estado' => 'inactivo',
    ]);
});

test('eliminar funcion cargo', function () {
    Sanctum::actingAs(User::factory()->create());

    $funcion = FuncionCargo::factory()->create();

    $response = $this->deleteJson(
        "/api/funcionCargos/{$funcion->id}"
    );

    $response->assertStatus(200);

    $this->assertDatabaseMissing('funcioCargo', [
        'id' => $funcion->id,
    ]);
});

test('no puede crear funcion cargo sin descripcion', function () {
    Sanctum::actingAs(User::factory()->create());

    $cargo = Cargo::factory()->create();

    $response = $this->postJson('/api/funcionCargos', [
        'estado' => 'activo',
        'id_cargo' => $cargo->id,
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['descripcion_funcion']);
});

test('no puede crear funcion cargo sin estado', function () {
    Sanctum::actingAs(User::factory()->create());

    $cargo = Cargo::factory()->create();

    $response = $this->postJson('/api/funcionCargos', [
        'descripcion_funcion' => 'Gestionar la base de datos',
        'id_cargo' => $cargo->id,
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['estado']);
});

test('no puede crear funcion cargo con estado invalido', function () {
    Sanctum::actingAs(User::factory()->create());

    $cargo = Cargo::factory()->create();

    $response = $this->postJson('/api/funcionCargos', [
        'descripcion_funcion' => 'Gestionar la base de datos',
        'estado' => 'pendiente',
        'id_cargo' => $cargo->id,
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['estado']);
});

test('no puede crear funcion cargo sin cargo', function () {
    Sanctum::actingAs(User::factory()->create());

    $response = $this->postJson('/api/funcionCargos', [
        'descripcion_funcion' => 'Gestionar la base de datos',
        'estado' => 'activo',
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['id_cargo']);
});

test('no puede crear funcion cargo con cargo inexistente', function () {
    Sanctum::actingAs(User::factory()->create());

    $response = $this->postJson('/api/funcionCargos', [
        'descripcion_funcion' => 'Gestionar la base de datos',
        'estado' => 'activo',
        'id_cargo' => 999,
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['id_cargo']);
});

test('no puede actualizar funcion cargo con estado invalido', function () {
    Sanctum::actingAs(User::factory()->create());

    $funcion = FuncionCargo::factory()->create();

    $response = $this->putJson("/api/funcionCargos/{$funcion->id}", [
        'estado' => 'pendiente',
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['estado']);
});

test('no puede actualizar funcion cargo con cargo inexistente', function () {
    Sanctum::actingAs(User::factory()->create());

    $funcion = FuncionCargo::factory()->create();

    $response = $this->putJson("/api/funcionCargos/{$funcion->id}", [
        'id_cargo' => 999,
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['id_cargo']);
});
