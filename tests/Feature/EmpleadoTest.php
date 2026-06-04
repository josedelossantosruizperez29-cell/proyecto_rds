<?php
// este test es para probar si verdaderamente se pueden listar los empleados
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\Cargo;
use App\Models\Empleados;
use Database\Factories\EmpleadosFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
class EmpleadoTest extends TestCase{
    use RefreshDatabase;

    public function test_listar_empleados(): void{
        $cargo = Cargo::factory()->create();
        Empleados::factory()->count(5)->create([
            'id_cargo' => $cargo->id
        ]);
        $response=$this->getJson('api/empleados');
        $response->assertStatus(200);
}
}

