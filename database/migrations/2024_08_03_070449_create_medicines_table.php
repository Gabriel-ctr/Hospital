<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicinesTable extends Migration
{
    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del medicamento
            $table->integer('quantity'); // Cantidad en inventario
            $table->text('description')->nullable(); // Descripción opcional
            $table->decimal('price', 8, 2); // Precio
            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    public function down()
    {
        Schema::dropIfExists('medicines');
    }
}
