<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagenesServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imagenes_servicios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 50)->default("")->nullable();
            $table->string('ruta', 255)->default("")->nullable();
            $table->unsignedBigInteger('servicio_id')->default(1);
            $table->timestamps();
            $table->foreign('servicio_id')->references('id')->on('servicios')->onUpdate('cascade')->onDelete('cascade');                         
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imagenes_servicios');
    }
}
