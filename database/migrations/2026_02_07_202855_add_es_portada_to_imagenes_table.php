<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEsPortadaToImagenesTable extends Migration
{
    public function up()
    {
        Schema::table('imagenes', function (Blueprint $table) {
            // Añadimos la columna después de la URL por orden visual
            $table->boolean('es_portada')->default(false)->after('url');
        });
    }

    public function down()
    {
        Schema::table('imagenes', function (Blueprint $table) {
            $table->dropColumn('es_portada');
        });
    }
}