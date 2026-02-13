<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropiedadesTable extends Migration
{
    public function up()
    {
        Schema::create('propiedades', function (Blueprint $table) {
            $table->id(); // Identificador único
            $table->enum('tipo', ['casa', 'departamento', 'local', 'cochera', 'terreno'])->default('casa'); 
            $table->enum('estado', ['alquiler', 'venta'])->default('venta');
            $table->decimal('precio', 10, 2);
            $table->string('direccion');
            $table->string('localidad');
            $table->text('descripcion');
            $table->unsignedInteger('metros_cuadrados')->nullable(); 
            $table->unsignedInteger('habitaciones')->nullable(); 
            $table->unsignedInteger('banos')->nullable();
            $table->string('imagen')->nullable();
            $table->boolean('disponible')->default(true); 
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('propiedades');
    }
}

