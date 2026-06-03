<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class funcionCargo extends Model
{
    // modelo funcionCargo

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
