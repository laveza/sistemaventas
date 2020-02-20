<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("idcategoria")->unsigned();
            $table->string("codigo","50")->nullable();
            $table->string("nombre","100")->unique();
            $table->decimal("precio_venta",11,2);
            $table->integer("stock");
            $table->integer("stock_inicial");
            $table->string("descripcion","256")->nullable();
            $table->string("imagen","180");
            $table->boolean("condicion")->default(1);
            $table->timestamps();

            /** UNIR TABLAS */
            $table->foreign("idcategoria")->references("id")->on("categorias");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulos');
    }
}
