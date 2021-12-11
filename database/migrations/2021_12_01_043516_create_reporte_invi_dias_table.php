<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReporteInviDiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reporte_invi_dias', function (Blueprint $table) {
            $table->id();
            $table->string('idinvi');
            $table->string('clave');
            $table->string('name');
            $table->string('lastname');
            $table->string('dni',8) ;            
            $table->string('horas')->default('0');
            $table->string('dia')->default('0');
            $table->bigInteger('socio_id')->unsigned();
            $table->bigInteger('clase_id')->unsigned();
            $table->foreign('socio_id')->references('id')->on('socios')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('estado')->default('0');
            $table->foreign('clase_id')->references('id')->on('clases')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('reporte_invi_dias');
    }
}
