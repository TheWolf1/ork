<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caja', function (Blueprint $table) {
            $table->id('caja_id');
            $table->unsignedBigInteger('caja_cajero');
            $table->float('caja_cantidad');
            $table->timestamps();



            $table->foreign('caja_cajero')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caja');
    }
}
