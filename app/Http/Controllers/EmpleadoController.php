<?php

namespace App\Http\Controllers;

use App\Models\Empleados;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // devuelve todos los empleados en json
        if (! Empleados::all()->isEmpty()) {
            return response()->json(Empleados::paginate(10));
        }

        return response()->json(['message' => 'No se encontraron empleados registrados'], 404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // funcion para crear un nuevo empleado
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'fecha_de_ingreso' => 'required|date',
            'salario' => 'required|numeric|min:0',
            'estado' => 'sometimes|in:activo,inactivo',
            'id_cargo' => 'required|exists:cargos,id',
        ], [
            'nombre.required' => 'El nombre del empleado es obligatorio.',
            'apellido.required' => 'El apellido del empleado es obligatorio.',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_de_ingreso.required' => 'La fecha de ingreso es obligatoria.',
            'salario.required' => 'El salario es obligatorio.',
            'salario.numeric' => 'El salario debe ser un numero.',
            'salario.min' => 'El salario no puede ser negativo.',
            'estado.in' => 'El estado debe ser activo o inactivo.',
            'id_cargo.required' => 'El cargo del empleado es obligatorio.',
            'id_cargo.exists' => 'El cargo seleccionado no existe.',
        ]);

        $empleado = Empleados::create($validated);

        return response()->json(['message' => 'Empleado creado correctamente', 'Empleado Creado' => $empleado], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // funcion para buscar un empleado por id
        $empleado = Empleados::find($id);
        if (! $empleado) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        return response()->json($empleado);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // funcion para actualizar los datos de un empleado
        $empleado = Empleados::find($id);
        if (! $empleado) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'apellido' => 'sometimes|required|string|max:255',
            'fecha_nacimiento' => 'sometimes|required|date',
            'fecha_de_ingreso' => 'sometimes|required|date',
            'salario' => 'sometimes|required|numeric|min:0',
            'estado' => 'sometimes|required|in:activo,inactivo',
            'id_cargo' => 'sometimes|required|exists:cargos,id',
        ], [
            'nombre.required' => 'El nombre del empleado es obligatorio.',
            'apellido.required' => 'El apellido del empleado es obligatorio.',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_de_ingreso.required' => 'La fecha de ingreso es obligatoria.',
            'salario.required' => 'El salario es obligatorio.',
            'salario.numeric' => 'El salario debe ser un numero.',
            'salario.min' => 'El salario no puede ser negativo.',
            'estado.in' => 'El estado debe ser activo o inactivo.',
            'id_cargo.required' => 'El cargo del empleado es obligatorio.',
            'id_cargo.exists' => 'El cargo seleccionado no existe.',
        ]);

        $empleado->update($validated);

        return response()->json(['message' => 'Datos del empleado actualizados correctamente', 'Empleado Actualizado' => $empleado], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // funcion para eliminar un empleado
        $empleado = Empleados::find($id);
        if (! $empleado) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }
        $empleado->delete();

        return response()->json(['message' => 'Empleado eliminado correctamente'], 200);
    }

    // funcion para mostrar los detalles empleados nombre , nombre de cargo,salaario y funciond de su cargo
    public function detalle_empleado($id)
    {
        $empleado = Empleados::with([
            'cargo',
            'cargo.funcioCargo',
        ])->find($id);
        if (! $empleado) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        return response()->json([
            'empleado' => $empleado->nombre.' '.$empleado->apellido,
            'cargo' => $empleado->cargo->nombre_cargo,
            'salario' => $empleado->salario,
            'funciones' => $empleado->cargo->funcioCargo->pluck('descripcion_funcion'),
        ]);

    }
}
