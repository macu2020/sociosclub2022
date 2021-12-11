<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitados', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname');
            $table->string('dni',8)->unique();            
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
        Schema::dropIfExists('invitados');
    }
}
