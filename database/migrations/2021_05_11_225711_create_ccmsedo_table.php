<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCcmsedoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ccmsedo', function (Blueprint $table) {
            $table->integer('id')->primary('ccmsedo_pkey');
            $table->string('MTIPODOC', 3)->nullable();
            $table->string('MNSERIE', 5)->nullable();
            $table->string('MINDAUT', 2)->nullable();
            $table->decimal('MNUMDOC', 7, 0)->nullable();
            $table->decimal('MNLINEAS', 2, 0)->nullable();
            $table->string('MCODCOLA', 3)->nullable();
            $table->string('MTIPFOR', 2)->nullable();
            $table->string('MOFI_INT', 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ccmsedo');
    }
}
