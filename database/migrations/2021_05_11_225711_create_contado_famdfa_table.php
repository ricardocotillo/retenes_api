<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContadoFamdfaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contado_famdfa', function (Blueprint $table) {
            $table->id();
            $table->string('mcoddfa', 11);
            $table->string('mcodcadi', 2)->nullable();
            $table->char('MCODVEN', 5)->nullable()->comment('CODIGO  VENDEDOR');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contado_famdfa');
    }
}
