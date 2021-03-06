<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDireccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direcciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ubicacion_id')->default(1)->nullable();
            $table->unsignedBigInteger('ciudad_id')->default(1)->nullable();
            $table->string('barrio',50)->default("")->nullable();
            $table->string('direccion',50)->default("")->nullable();
            $table->foreign('ubicacion_id')->references('id')->on('ubicaciones')->onUpdate('cascade'); 
            $table->foreign('ciudad_id')->references('id')->on('ciudades')->onUpdate('cascade'); 
            $table->softDeletes();
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
        Schema::dropIfExists('direcciones');
    }
}
