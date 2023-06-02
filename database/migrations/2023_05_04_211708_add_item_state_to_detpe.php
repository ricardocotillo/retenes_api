<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemStateToDetpe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detpe', function (Blueprint $table) {
            $table->string('item_state', 10)->default('espera'); // espera, pendiente, atendido, atendido_parcial, pendiente
            $table->date('fecha_despacho')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detpe', function (Blueprint $table) {
            //
        });
    }
}
