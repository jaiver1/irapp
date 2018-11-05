<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('referencia', 50);
            $table->string('nombre', 50);
            $table->double('valor_unitario', 12, 2);
            $table->text('descripcion');
            $table->unsignedBigInteger('medida_id')->default(1);
            $table->unsignedBigInteger('categoria_id')->default(1);
            $table->unsignedBigInteger('marca_id')->default(1);
            $table->unsignedBigInteger('tipo_referencia_id')->default(1);         
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('medida_id')->references('id')->on('medidas')->onUpdate('cascade')->onDelete('cascade');                         
            $table->foreign('marca_id')->references('id')->on('marcas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tipo_referencia_id')->references('id')->on('tipos_referencias')->onUpdate('cascade')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
