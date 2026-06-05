<?php

namespace Tests\Feature;
use Tests\TestCase;
use App\Models\Cargo;
use App\Models\Empleados;
use laravel\Sanctum\Sanctum;
use Database\Factories\EmpleadosFactory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
class buscar_empleado extends TestCase{
    use RefreshDatabase;

    public function test_puede_buscar_un_empleado_solo_si_el_usuario_esta_autenticado(): void{
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $cargo = Cargo::factory()->create();
       $empleado = Empleados::factory()->create([
            'id_cargo' => $cargo->id
        ]);
        $response=$this->getJson("api/empleados/{$empleado->id}");
        $response->assertStatus(200);
}
}

