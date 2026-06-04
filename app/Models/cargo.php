<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cargo extends Model
{
    // modelo de cargo

    protected $fillable = [
        'nombre_cargo',
        'descripcion',
    ];

    public function empleados()
    {
        return $this->hasMany(Empleados::class);
    }

    public function funcionCargo()
    {
        return $this->hasMany(FuncionCargo::class);
    }
}
