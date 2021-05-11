<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticuloFamdfaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulo_famdfa', function (Blueprint $table) {
            $table->id();
            $table->string('mcodart', 16)->nullable();
            $table->string('mcoddfa', 6)->nullable();
            $table->string('MCODRVE', 2)->nullable();
            $table->string('MCODCADI', 2)->nullable();
            $table->string('MCONDPAGO', 2)->nullable();
            $table->integer('MCANMIN')->nullable();
            $table->integer('MCANMAX')->nullable();
            $table->string('DESCRIP_DESCUENTO', 20)->nullable();
            $table->char('MCODVEN', 5)->nullable()->comment('CODIGO  VENDEDOR');
            $table->string('MCODCLI', 16)->nullable();
            $table->decimal('MPRECIO', 14, 4)->nullable();
            $table->string('MCODZON', 5)->nullable();
            $table->decimal('impneto_min', 14, 4)->nullable();
            $table->decimal('impneto_max', 14, 4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulo_famdfa');
    }
}
