<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCiisaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ciisa', function (Blueprint $table) {
            $table->id('RUT');
            $table->string('DV')->nullable();
            $table->string('NOMBRES')->nullable();
            $table->string('PATERNO')->nullable();
            $table->string('MATERNO')->nullable();
            $table->string('SEXOT_COD')->nullable();
            $table->dateTime('FECHA_NACIMIENTO')->nullable();
            $table->string('DIRECCION')->nullable();
            $table->string('REGIN_COD')->nullable();
            $table->string('COMUN_COD')->nullable();
            $table->string('CIUDN')->nullable();
            $table->string('TELEFONO_CODIGO_AREA')->nullable();
            $table->string('TELEFONO_FIJO')->nullable();
            $table->string('TELEFONO_CELULAR')->nullable();
            $table->string('EMAIL')->nullable();
            $table->string('TIESN_COD')->nullable();
            $table->string('IESN_COD')->nullable();
            $table->string('SEDEN_COD')->nullable();
            $table->string('CARRN_COD')->nullable();
            $table->string('JORNN_COD')->nullable();
            $table->string('ARANCEL_REAL')->nullable();
            $table->string('MARCA_EGRESO')->nullable();
            $table->dateTime('FECHA_EGRESO')->nullable();
            $table->dateTime('FECHA_ULTIMA_MATRICULA')->nullable();
            $table->string('MARCA_CONTINUIDAD')->nullable();
            $table->string('NESTN_COD')->nullable();
            $table->string('MARCA_CUMPLE_EXIGENCIAS')->nullable();
            $table->string('PERIODO_CARGA')->nullable();
            $table->dateTime('FECHA_CARGA_INICIAL')->nullable();
            $table->dateTime('FECHA_ULTIMA_ACTUALIZACION')->nullable();
            $table->string('COMPROBANTE_MATRICULA')->nullable();
            $table->string('REQUIERE_FINANCIAMIENTO')->nullable();
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
        Schema::dropIfExists('ciisa');
    }
}
