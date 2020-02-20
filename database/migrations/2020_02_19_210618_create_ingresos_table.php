<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("idproveedor")->unsigned();
            $table->integer("idusuario")->unsigned();
            $table->string("tipo_comprobante",20);
            $table->string("serie_comprobante",7)->nullable();
            $table->string("num_comprobante",10);
            $table->dateTime("fecha_hora");
            $table->decimal("impuesto",4,2);
            $table->decimal("total",11,2);
            $table->string("estado",20);
            $table->foreign("idproveedor")->references("idpersona")->on("proveedores");
            $table->foreign("idusuario")->references("idpersona")->on("users");
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
        Schema::dropIfExists('ingresos');
    }
}
