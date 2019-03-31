<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallesOrdenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_ordenes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 50);
            $table->double('valor_unitario', 12, 2);
            $table->double('cantidad', 12, 2);
            $table->enum('estado', ['Abierta', 'Cerrada', 'Cancelada', 'Pendiente']);
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin')->nullable();
            $table->unsignedBigInteger('colaborador_id')->nullable();
            $table->unsignedBigInteger('servicio_id');
            $table->unsignedBigInteger('orden_id');
            $table->foreign('servicio_id')->references('id')->on('servicios')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('orden_id')->references('id')->on('ordenes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('colaborador_id')->references('id')->on('colaboradores')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalles_ordenes');
    }
}
