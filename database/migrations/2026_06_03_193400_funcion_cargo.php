<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('funcioCargo', function (Blueprint $table) {
           $table->id();
           $table->string('descripcion_funcion');
           $table->enum('estado', ['activo', 'inactivo'])->default('activo');
           $table->foreignId('id_cargo')->constrained('cargos')->cascadeOnUpdate()->cascadeOnDelete();
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
