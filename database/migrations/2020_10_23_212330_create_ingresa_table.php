<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresa', function (Blueprint $table) {
            $table->id('RUT');
            $table->string('DV')->nullable();
            $table->string('PATERNO')->nullable();
            $table->string('MATERNO')->nullable();
            $table->string('NOMBRES')->nullable();
            $table->string('TIESN_COD')->nullable();
            $table->string('IESN_COD')->nullable();
            $table->string('SEDEN_COD')->nullable();
            $table->string('CARRN_COD')->nullable();
            $table->string('JORNN_COD')->nullable();
            $table->string('NOMBRE_TIPO_TITULO')->nullable();
            $table->string('NOMBRE_AREA_CONOCIMIENTO')->nullable();
            $table->string('NOMBRE_IES')->nullable();
            $table->string('NOMBRE_CARRERA')->nullable();
            $table->string('ANO_LICITACION')->nullable();
            $table->string('ESTADO_RENOVANTE')->nullable();
            $table->string('PSU_VIGENTE')->nullable();
            $table->string('NEM_VIGENTE')->nullable();
            $table->string('CONTADOR_CAMBIOS')->nullable();
            $table->string('ANOS_DURACION_CARRERA')->nullable();
            $table->string('ULTIMO_NIVEL_ESTUDIO_IES')->nullable();
            $table->string('CONTADOR_ANOS_FINANCIADOS')->nullable();
            $table->string('ANOS_MAXIMOS_POR_FINANCIAR')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingresa');
    }
}
