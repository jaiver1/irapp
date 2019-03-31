<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallesSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_solicitudes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 50);
            $table->double('valor_unitario', 12, 2);
            $table->double('cantidad', 12, 2);
            $table->enum('estado', ['Abierta', 'Cancelada', 'Pendiente']);
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin')->nullable();
            $table->unsignedBigInteger('colaborador_id')->nullable();
            $table->unsignedBigInteger('servicio_id');
            $table->unsignedBigInteger('solicitud_id');
            $table->foreign('servicio_id')->references('id')->on('servicios')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('solicitud_id')->references('id')->on('solicitudes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('colaborador_id')->references('id')->on('colaboradores')->onUpdate('cascade');
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
        Schema::dropIfExists('detalles_solicitudes');
    }
}
