<?php
// el usuario puede actualizar un empleado solo si esta autenticado
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\Cargo;
use App\Models\Empleados;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
class Test_actualizar_empleado extends TestCase{
    use RefreshDatabase;

    public function test_puede_actualizar_un_empleado_solo_si_el_usuario_esta_autenticado(): void{
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $cargo=Cargo::factory()->create();
        $datos=[
            'nombre'=>'jose_actualizado',
            'apellido'=>'ruiz_actualizado',
        ];
        $empleado = Empleados::factory()->create([
            'id_cargo' => $cargo->id
        ]);
        $response=$this->putJson("/api/empleados/{$empleado->id}", $datos);
        $response->assertStatus(200);
        //verificar que la informacion del usuario fue actualizada correctamente en la base de datos
       $this->assertDatabaseHas('empleados', $datos);
        

        

}
}