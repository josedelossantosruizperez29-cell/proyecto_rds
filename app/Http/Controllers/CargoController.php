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
        if(!Cargo::all()->isEmpty()){
            return response()->json(Cargo::all());
        }
        return response()->json(['message' => 'No se encontraron cargos'], 404);
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
        $cargo = Cargo::create($request->all());
        return response()->json(['message' => 'Cargo creado correctamente', 'Cargo Creado' => $cargo], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
