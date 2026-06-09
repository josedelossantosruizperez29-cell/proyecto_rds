<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FuncionCargo extends Model
{
    // modelo funcionCargo
    use HasFactory;
    protected $table = 'funcioCargo';
    protected $fillable = [
        'descripcion_funcion',
        'estado',
        'id_cargo',
    ];

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }   


}
