<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empleados extends Model
{
    //modelo de empleados

    use hasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'fecha_de_ingreso',
        'salario',
        'estado',
        'id_cargo',
    ];

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }
}
