<?php

use App\Models\Cargo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

test('listar cargos solo si el usuario esta autenticado', function () {
    Sanctum::actingAs(User::factory()->create());

    Cargo::factory()->count(3)->create();

    $response = $this->getJson('/api/cargos');

    $response->assertStatus(200);
});

test('no puede listar cargos sin autenticacion', function () {
    $response = $this->getJson('/api/cargos');

    $response
        ->assertStatus(401)
        ->assertJsonPath('message', 'No autenticado. Debes iniciar sesion para acceder a este recurso.');
});

test('crear cargo', function () {
    Sanctum::actingAs(User::factory()->create());

    $datos = [
        'nombre_cargo' => 'Desarrollador Backend',
        'descripcion' => 'Encargado de desarrollar APIs',
    ];

    $response = $this->postJson('/api/cargos', $datos);

    $response->assertStatus(201);

    $this->assertDatabaseHas('cargos', [
        'nombre_cargo' => 'Desarrollador Backend',
    ]);
});

test('mostrar un solo cargo por id', function () {
    Sanctum::actingAs(User::factory()->create());

    $cargo = Cargo::factory()->create();

    $response = $this->getJson("/api/cargos/{$cargo->id}");

    $response->assertStatus(200);

    $response->assertJson([
        'id' => $cargo->id,
        'nombre_cargo' => $cargo->nombre_cargo,
    ]);
});

test('actualizar cargo', function () {
    Sanctum::actingAs(User::factory()->create());

    $cargo = Cargo::factory()->create();

    $datosActualizados = [
        'nombre_cargo' => 'Arquitecto de Software',
        'descripcion' => 'Disena la arquitectura del sistema',
    ];

    $response = $this->putJson("/api/cargos/{$cargo->id}", $datosActualizados);

    $response->assertStatus(200);

    $this->assertDatabaseHas('cargos', [
        'id' => $cargo->id,
        'nombre_cargo' => 'Arquitecto de Software',
        'descripcion' => 'Disena la arquitectura del sistema',
    ]);
});

test('eliminar cargo', function () {
    Sanctum::actingAs(User::factory()->create());

    $cargo = Cargo::factory()->create();

    $response = $this->deleteJson("/api/cargos/{$cargo->id}");

    $response->assertStatus(200);

    $this->assertDatabaseMissing('cargos', [
        'id' => $cargo->id,
    ]);
});

test('no puede crear cargo sin nombre', function () {
    Sanctum::actingAs(User::factory()->create());

    $response = $this->postJson('/api/cargos', [
        'descripcion' => 'Encargado de desarrollar APIs',
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['nombre_cargo']);
});

test('no puede crear cargo sin descripcion', function () {
    Sanctum::actingAs(User::factory()->create());

    $response = $this->postJson('/api/cargos', [
        'nombre_cargo' => 'Desarrollador Backend',
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['descripcion']);
});

test('no puede actualizar cargo con nombre vacio', function () {
    Sanctum::actingAs(User::factory()->create());

    $cargo = Cargo::factory()->create();

    $response = $this->putJson("/api/cargos/{$cargo->id}", [
        'nombre_cargo' => '',
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['nombre_cargo']);
});

test('no puede actualizar cargo con descripcion vacia', function () {
    Sanctum::actingAs(User::factory()->create());

    $cargo = Cargo::factory()->create();

    $response = $this->putJson("/api/cargos/{$cargo->id}", [
        'descripcion' => '',
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['descripcion']);
});
