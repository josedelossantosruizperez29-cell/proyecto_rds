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
        if(!Empleados::all()->isEmpty()){
            return response()->json(Empleados::all());
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
        $empleado = Empleados::create($request->all());
        return response()->json(['message' => 'Empleado creado correctamente', 'Empleado Creado' => $empleado], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //funcion para buscar un empleado por id
        $empleado = Empleados::find($id);
        if (!$empleado) {
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
    public function update(Request $request, string $id)
    {
        //funcion para actualizar los datos de un empleado
        $empleado = Empleados::find($id);
        if (!$empleado) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }
        $empleado->update($request->all());
        return response()->json(['message' => 'Datos del empleado actualizados correctamente', 'Empleado Actualizado' => $empleado], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //funcion para eliminar un empleado
        $empleado = Empleados::find($id);
        if (!$empleado) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }
        $empleado->delete();
        return response()->json(['message' => 'Empleado eliminado correctamente'], 200);
    }
}
