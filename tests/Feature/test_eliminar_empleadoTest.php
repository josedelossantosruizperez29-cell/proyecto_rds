<?php

use App\Models\Cargo;
use App\Models\Empleados;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

test('puede eliminar un empleado solo si el usuario esta autenticado', function () {
    Sanctum::actingAs(User::factory()->create());

    $cargo = Cargo::factory()->create();

    $empleado = Empleados::factory()->create([
        'id_cargo' => $cargo->id,
    ]);

    $response = $this->deleteJson("/api/empleados/{$empleado->id}");

    $response->assertStatus(200);
    $this->assertDatabaseMissing('empleados', ['id' => $empleado->id]);
});
