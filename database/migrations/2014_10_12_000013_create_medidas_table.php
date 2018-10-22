<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medidas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 50);
            $table->string('etiqueta', 5);
            $table->unsignedBigInteger('tipo_medida_id')->default(1);  
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('tipo_medida_id')->references('id')->on('tipos_medidas')->onUpdate('cascade')->onDelete('cascade');                         
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medidas');
    }
}
