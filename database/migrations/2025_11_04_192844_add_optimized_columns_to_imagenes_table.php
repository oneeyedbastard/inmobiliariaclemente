<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOptimizedColumnsToImagenesTable extends Migration
{
    public function up()
    {
        Schema::table('imagenes', function (Blueprint $table) {         
            $table->string('url_main')->nullable()->after('propiedad_id');
            $table->string('url_thumb')->nullable()->after('url_main');
        });
    }

    public function down()
    {
        Schema::table('imagenes', function (Blueprint $table) {
            $table->dropColumn('url_main');
            $table->dropColumn('url_thumb');
        });
    }
}