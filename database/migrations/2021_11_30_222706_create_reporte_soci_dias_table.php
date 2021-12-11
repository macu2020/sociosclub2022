<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReporteSociDiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reporte_soci_dias', function (Blueprint $table) {
            $table->id();
            $table->string('idsoci');
            $table->string('clave');
            $table->string('name');
            $table->string('lastname');
            $table->string('dni',8);            
            $table->bigInteger('perfil_id')->unsigned();      
            $table->bigInteger('parentesco_id')->unsigned();      
            $table->bigInteger('clase_id')->unsigned();      
            $table->string('email') ;
            $table->integer('estado')->default('0');
            $table->string('avatar')->nullable();
            $table->string('horas')->default('0');
            $table->string('dia')->default('0');
            $table->foreign('perfil_id')->references('id')->on('perfils')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('parentesco_id')->references('id')->on('parentescos')->onDelete('cascade')->onUpdate('cascade');            
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
        Schema::dropIfExists('reporte_soci_dias');
    }
}
