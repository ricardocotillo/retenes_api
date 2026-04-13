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
        Schema::create('articulo_famdfa_tipo_de_descuento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('articulo_famdfa_id');
            $table->unsignedBigInteger('tipo_de_descuento_id');
            $table->timestamps();

            $table->foreign('articulo_famdfa_id', 'af_td_af_id_foreign')
                ->references('id')->on('articulo_famdfa')
                ->onDelete('cascade');

            $table->foreign('tipo_de_descuento_id', 'af_td_td_id_foreign')
                ->references('id')->on('tipo_de_descuentos')
                ->onDelete('restrict');

            $table->unique(['articulo_famdfa_id', 'tipo_de_descuento_id'], 'af_td_unique');
            $table->index('tipo_de_descuento_id', 'af_td_td_id_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulo_famdfa_tipo_de_descuento');
    }
};
