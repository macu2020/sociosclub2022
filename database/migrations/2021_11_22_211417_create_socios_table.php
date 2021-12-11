<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSociosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socios', function (Blueprint $table) {
            $table->id();
            $table->string('clave');
            $table->string('name');
            $table->string('lastname');
            $table->string('dni',8)->unique();            
            $table->bigInteger('perfil_id')->unsigned();      
            $table->bigInteger('parentesco_id')->unsigned();      
            $table->bigInteger('clase_id')->unsigned();      
            $table->string('email')->unique();
            $table->integer('estado')->default('0');
            $table->string('avatar')->nullable();
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
        Schema::dropIfExists('socios');
    }
}
