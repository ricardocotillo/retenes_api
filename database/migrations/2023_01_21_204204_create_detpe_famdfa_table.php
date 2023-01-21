<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetpeFamdfaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detpe_famdfa', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Detpe::class);
            $table->foreignIdFor(Famdfa::class);
            $table->string('type', 15); // item, retenes, filtros, general
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
        Schema::dropIfExists('detpe_famdfa');
    }
}
