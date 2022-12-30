<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            //NUEVA COLUMNA DE LA TABLA QUESTIONS PARA AGREGAR LAS REGLAS ORTOGRAFICAS EN LAS ACTIVIDADES DE PRACTICA
            $table->longText('rule')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            //FUNCION PARA ELIMINAR LA COLUMNA SI SURJE ALGUN PROBLEMA
            $table->dropColumn('rule');
        });
    }
};
