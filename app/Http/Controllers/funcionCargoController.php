<?php

namespace App\Http\Controllers;

use App\Models\FuncionCargo;
use Illuminate\Http\Request;

class funcionCargoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // listar todas las funciones de los cargos
        if (! FuncionCargo::all()->isEmpty()) {
            return response()->json(FuncionCargo::paginate(10));
        }

        return response()->json(['message' => 'No se encontraron funciones de cargos'], 404);
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
        // funcion para crear una nueva funcion de cargo
        $validated = $request->validate([
            'descripcion_funcion' => 'required|string|max:1000',
            'estado' => 'required|in:activo,inactivo',
            'id_cargo' => 'required|exists:cargos,id',
        ], [
            'descripcion_funcion.required' => 'La descripcion de la funcion es obligatoria.',
            'descripcion_funcion.string' => 'La descripcion de la funcion debe ser texto.',
            'descripcion_funcion.max' => 'La descripcion de la funcion no puede superar 1000 caracteres.',
            'estado.required' => 'El estado de la funcion es obligatorio.',
            'estado.in' => 'El estado debe ser activo o inactivo.',
            'id_cargo.required' => 'El cargo de la funcion es obligatorio.',
            'id_cargo.exists' => 'El cargo seleccionado no existe.',
        ]);

        $funcionCargo = FuncionCargo::create($validated);

        return response()->json(['message' => 'Funcion de cargo creada correctamente', 'Funcion de Cargo Creada' => $funcionCargo], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // mostrar una funcion de cargo por id
        $funcionCargo = FuncionCargo::find($id);
        if (! $funcionCargo) {
            return response()->json(['message' => 'Funcion de cargo no encontrado'], 404);
        }

        return response()->json($funcionCargo);
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
    public function update(Request $request, string $id)
    {
        // actualizar los datos de una funcion de cargo
        $funcionCargo = FuncionCargo::find($id);
        if (! $funcionCargo) {
            return response()->json(['message' => 'Funcion de cargo no encontrado'], 404);
        }

        $validated = $request->validate([
            'descripcion_funcion' => 'sometimes|required|string|max:1000',
            'estado' => 'sometimes|required|in:activo,inactivo',
            'id_cargo' => 'sometimes|required|exists:cargos,id',
        ], [
            'descripcion_funcion.required' => 'La descripcion de la funcion es obligatoria.',
            'descripcion_funcion.string' => 'La descripcion de la funcion debe ser texto.',
            'descripcion_funcion.max' => 'La descripcion de la funcion no puede superar 1000 caracteres.',
            'estado.required' => 'El estado de la funcion es obligatorio.',
            'estado.in' => 'El estado debe ser activo o inactivo.',
            'id_cargo.required' => 'El cargo de la funcion es obligatorio.',
            'id_cargo.exists' => 'El cargo seleccionado no existe.',
        ]);

        $funcionCargo->update($validated);

        return response()->json(['message' => 'Datos de la funcion de cargo actualizados correctamente', 'Funcion de Cargo Actualizado' => $funcionCargo], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // eliminar un funcion de cargo
        $funcionCargo = FuncionCargo::find($id);
        if (! $funcionCargo) {
            return response()->json(['message' => 'Funcion de cargo no encontrado'], 404);
        }
        $funcionCargo->delete();

        return response()->json(['message' => 'Funcion de cargo eliminada correctamente'], 200);
    }
}
