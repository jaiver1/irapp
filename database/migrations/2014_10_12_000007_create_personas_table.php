<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cedula')->default(1)->nullable();
            $table->string('primer_nombre', 50)->default("")->nullable();
            $table->string('segundo_nombre', 50)->default("")->nullable();
            $table->string('primer_apellido', 50)->default("")->nullable();
            $table->string('segundo_apellido', 50)->default("")->nullable();
            $table->string('telefono_fijo', 50)->default("")->nullable();
            $table->string('telefono_movil', 50)->default("")->nullable();
            $table->unsignedBigInteger('ciudad_id')->default(1)->nullable();
            $table->unsignedBigInteger('ubicacion_id')->default(1)->nullable();
            $table->string('barrio',50)->default("")->nullable();
            $table->string('direccion',50)->default("")->nullable();
            $table->string('cuenta_banco', 50)->default("")->nullable();
            $table->string('imagen', 255)->default("")->nullable();
            $table->unsignedBigInteger('usuario_id')->default(1)->nullable();
            $table->foreign('ubicacion_id')->references('id')->on('ubicaciones')->onUpdate('cascade'); 
            $table->foreign('ciudad_id')->references('id')->on('ciudades')->onUpdate('cascade'); 
            $table->foreign('usuario_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');                 
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
        Schema::dropIfExists('personas');
    }
}
