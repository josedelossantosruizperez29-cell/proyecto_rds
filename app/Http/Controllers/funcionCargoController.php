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
        //listar todas las funciones de los cargos
        if(!FuncionCargo::all()->isEmpty()){
            return response()->json(FuncionCargo::all());
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
        //funcion para crear una nueva funcion de cargo
        $funcionCargo = FuncionCargo::create($request->all());
        return response()->json(['message' => 'Funcion de cargo creada correctamente', 'Funcion de Cargo Creada' => $funcionCargo], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //mostrar una funcion de cargo por id
        $funcionCargo = FuncionCargo::find($id);
        if (!$funcionCargo) {
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
        //actualizar los datos de una funcion de cargo
        $funcionCargo = FuncionCargo::find($id);
        if (!$funcionCargo) {
            return response()->json(['message' => 'Funcion de cargo no encontrado'], 404);
        }
        $funcionCargo->update($request->all());
        return response()->json(['message' => 'Datos de la funcion de cargo actualizados correctamente', 'Funcion de Cargo Actualizado' => $funcionCargo], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //eliminar un funcion de cargo
        $funcionCargo = FuncionCargo::find($id);
        if (!$funcionCargo) {
            return response()->json(['message' => 'Funcion de cargo no encontrado'], 404);
        }
        $funcionCargo->delete();
        return response()->json(['message' => 'Funcion de cargo eliminada correctamente'], 200);
    }
}
