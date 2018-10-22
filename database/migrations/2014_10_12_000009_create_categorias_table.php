<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 50);
            $table->unsignedBigInteger('especialidad_id')->default(1);
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('especialidad_id')->references('id')->on('especialidades')->onUpdate('cascade')->onDelete('cascade');            
            $table->foreign('categoria_id')->references('id')->on('categorias')->onUpdate('cascade')->onDelete('cascade');            
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorias');
    }
}
