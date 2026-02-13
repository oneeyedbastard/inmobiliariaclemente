<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSmallMediumColumnsToImagenesTable extends Migration
{
    public function up()
    {
        Schema::table('imagenes', function (Blueprint $table) {
            $table->string('url_small')->nullable()->after('url_thumb');
            $table->string('url_medium')->nullable()->after('url_small');
        });
    }

    public function down()
    {
        Schema::table('imagenes', function (Blueprint $table) {
            $table->dropColumn(['url_small', 'url_medium']);
        });
    }
}