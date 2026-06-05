<?php
// el usuario puede eliminar un empleado solo si esta autenticado
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\Cargo;
use App\Models\Empleados;
use Laravel\Sanctum\Sanctum;
use Database\Factories\EmpleadosFactory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
class eliminar_empleado extends TestCase{
    use RefreshDatabase;

    public function test_puede_eliminar_un_empleado_solo_si_el_usuario_esta_autenticado(): void{
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $cargo = Cargo::factory()->create();
       $empleado = Empleados::factory()->create([
            'id_cargo' => $cargo->id
        ]);
        $response=$this->deleteJson("/api/empleados/{$empleado->id}");
        //verificar que el empleado se elimino correctamente de la base de datos
        $response->assertStatus(200);
        $this->assertDatabaseMissing('empleados', ['id' => $empleado->id]);
}
}
