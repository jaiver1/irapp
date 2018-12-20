<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordenes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 50);
            $table->enum('estado', ['Abierta', 'Cerrada', 'Cancelada', 'Pendiente']);
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin')->nullable();
            $table->unsignedBigInteger('ciudad_id')->default(1);
            $table->unsignedBigInteger('ubicacion_id')->default(1)->nullable();
            $table->unsignedBigInteger('cliente_id');
            $table->string('barrio',50)->default("")->nullable()->nullable();
            $table->string('direccion',50)->default("")->nullable();
            $table->foreign('ubicacion_id')->references('id')->on('ubicaciones')->onUpdate('cascade')->onDelete('cascade');      
            $table->foreign('ciudad_id')->references('id')->on('ciudades')->onUpdate('cascade'); 
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
        Schema::dropIfExists('colaboradores_servicios');
    }
}
