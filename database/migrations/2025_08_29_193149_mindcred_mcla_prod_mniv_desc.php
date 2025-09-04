<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articulo_famdfa', function (Blueprint $table) {
            $table->string('mindcred', 2)->nullable();
            $table->string('mcla_prod', 3)->nullable();
            // $table->integer('mniv_desc'); # 1 = retenes, 2 = repuestos, 3 = general
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
};
