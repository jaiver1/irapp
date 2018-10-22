<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class XCreateCalificacionesProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calificaciones_productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('descripcion')->nullable();
            $table->unsignedTinyInteger('calificacion')->default(5);
            $table->unsignedBigInteger('producto_id')->default(1);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('producto_id')->references('id')->on('productos')->onUpdate('cascade')->onDelete('cascade');                         
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calificaciones_productos');
    }
}
