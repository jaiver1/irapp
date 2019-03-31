<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalificacionesServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calificaciones_servicios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('descripcion')->nullable();
            $table->unsignedTinyInteger('calificacion')->default(5);
            $table->unsignedBigInteger('servicio_id')->default(1);
            $table->unsignedBigInteger('usuario_id')->default(1)->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('servicio_id')->references('id')->on('servicios')->onUpdate('cascade')->onDelete('cascade');       
            $table->foreign('usuario_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');                                   
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calificaciones_servicios');
    }
}
