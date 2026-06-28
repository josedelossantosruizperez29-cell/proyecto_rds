<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // retorna todos los cargos en json
        if (! Cargo::all()->isEmpty()) {
            return response()->json(Cargo::paginate(10));
        }

        return response()->json(['message' => 'No se encontraron cargos'], 404);
    }

    public function detalle_cargos(){
    $cargos = Cargo::with('funcioCargo')->get();

return response()->json(
    $cargos->map(function ($cargo) {
        return [
            'cargo' => $cargo->nombre_cargo,
            'funciones' => $cargo->funcioCargo->pluck('descripcion_funcion'),
        ];
    })
);

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
        // funcion para crear un nuevo cargo
        $validated = $request->validate([
            'nombre_cargo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
        ], [
            'nombre_cargo.required' => 'El nombre del cargo es obligatorio.',
            'nombre_cargo.string' => 'El nombre del cargo debe ser texto.',
            'nombre_cargo.max' => 'El nombre del cargo no puede superar 255 caracteres.',
            'descripcion.required' => 'La descripcion del cargo es obligatoria.',
            'descripcion.string' => 'La descripcion del cargo debe ser texto.',
            'descripcion.max' => 'La descripcion del cargo no puede superar 1000 caracteres.',
        ]);

        $cargo = Cargo::create($validated);

        return response()->json(['message' => 'Cargo creado correctamente', 'Cargo Creado' => $cargo], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // funcione para buscar un cargo por id
        $cargo = Cargo::find($id);
        if (! $cargo) {
            return response()->json(['message' => 'Cargo no encontrado'], 404);
        }

        return response()->json($cargo);
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
        // funcion para actualizar los datos de un cargo
        $cargo = Cargo::find($id);
        if (! $cargo) {
            return response()->json(['message' => 'Cargo no encontrado'], 404);
        }

        $validated = $request->validate([
            'nombre_cargo' => 'sometimes|required|string|max:255',
            'descripcion' => 'sometimes|required|string|max:1000',
        ], [
            'nombre_cargo.required' => 'El nombre del cargo es obligatorio.',
            'nombre_cargo.string' => 'El nombre del cargo debe ser texto.',
            'nombre_cargo.max' => 'El nombre del cargo no puede superar 255 caracteres.',
            'descripcion.required' => 'La descripcion del cargo es obligatoria.',
            'descripcion.string' => 'La descripcion del cargo debe ser texto.',
            'descripcion.max' => 'La descripcion del cargo no puede superar 1000 caracteres.',
        ]);

        $cargo->update($validated);

        return response()->json(['message' => 'Datos del cargo actualizados correctamente', 'Cargo Actualizado' => $cargo], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // funcion para eliminar un cargo
        $cargo = Cargo::find($id);
        if (! $cargo) {
            return response()->json(['message' => 'Cargo no encontrado'], 404);
        }
        $cargo->delete();

        return response()->json(['message' => 'Cargo eliminado correctamente'], 200);
    }
}
