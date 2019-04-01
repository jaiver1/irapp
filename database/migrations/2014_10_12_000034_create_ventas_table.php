<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('fecha');
            $table->unsignedBigInteger('direccion_id')->default(1)->nullable();
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->enum('estado', ['Abierta','Cancelada', 'Pendiente','Entregado', 'Enviado']);
            $table->foreign('direccion_id')->references('id')->on('direcciones')->onUpdate('cascade'); 
            $table->foreign('cliente_id')->references('id')->on('clientes')->onUpdate('cascade');
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
        Schema::dropIfExists('ventas');
    }
}
