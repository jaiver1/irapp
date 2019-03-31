<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallesComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_compras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('valor_unitario', 12, 2);
            $table->double('cantidad', 12, 2);         
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('proveedor_id')->nullable();
            $table->unsignedBigInteger('compra_id');
            $table->foreign('producto_id')->references('id')->on('productos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onUpdate('cascade');
            $table->foreign('compra_id')->references('id')->on('compras')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('detalles_compras');
    }
}
