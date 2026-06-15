<?php

use App\Models\Cargo;
use App\Models\Empleados;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

test('listar empleados solo si el usuario esta autenticado', function () {
    Sanctum::actingAs(User::factory()->create());

    $cargo = Cargo::factory()->create();

    Empleados::factory()->count(5)->create([
        'id_cargo' => $cargo->id,
    ]);

    $response = $this->getJson('/api/empleados');

    $response->assertStatus(200);
});

test('no puede listar empleados sin autenticacion', function () {
    $response = $this->getJson('/api/empleados');

    $response
        ->assertStatus(401)
        ->assertJsonPath('message', 'No autenticado. Debes iniciar sesion para acceder a este recurso.');
});
