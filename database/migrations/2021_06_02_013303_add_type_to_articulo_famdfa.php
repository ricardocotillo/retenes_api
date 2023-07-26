<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToArticuloFamdfa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articulo_famdfa', function (Blueprint $table) {
            $table->string('tipo', 16)->nullable(); #retenes, repuestos o all
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articulo_famdfa', function (Blueprint $table) {
            //
        });
    }
}
