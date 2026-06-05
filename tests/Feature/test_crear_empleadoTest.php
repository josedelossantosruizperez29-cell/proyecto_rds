<?php
// el usuario puede crear un empleado solo si esta autenticado
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\Cargo;
use App\Models\Empleados;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
class crear_empleado extends TestCase{
    use RefreshDatabase;

    public function test_puede_crear_un_empleado_solo_si_el_usuario_esta_autenticado(): void{
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $cargo=Cargo::factory()->create();
        $datos=[
            'nombre'=>'jose',
            'apellido'=>'ruiz',
            'fecha_nacimiento'=>'2000-01-01',
            'fecha_de_ingreso'=>'2023-01-01',
            'salario'=>'2500000',
            'id_cargo'=>$cargo->id,
        ];
        $response=$this->postJson('/api/empleados', $datos);
        $response->assertStatus(201);
        //verificar que el usuario se creo correctamente en la base de datos
        $this->assertDatabaseHas('empleados', $datos);
        

        

}
}