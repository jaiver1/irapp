<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColaboradoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('persona_id');
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('persona_id')->references('id')->on('personas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onUpdate('cascade')->onDelete('cascade');
            $table->rememberToken();
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
        Schema::dropIfExists('colaboradores');
    }
}
