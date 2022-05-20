<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido', function (Blueprint $table) {
            $table->id('pedido_id');
            $table->longText('pedido_obj');
            $table->string('pedido_cliente');
            $table->unsignedBigInteger('pedido_mesero');
            $table->unsignedBigInteger('pedido_mesa');
            $table->string('pedido_estado');
            $table->float('pedido_precio',5,2);
            
            $table->timestamps();
            $table->foreign('pedido_mesa')->references('mesa_id')->on('mesa');
            $table->foreign('pedido_mesero')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedido');
    }
}
