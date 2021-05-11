<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCcmmonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ccmmon', function (Blueprint $table) {
            $table->id();
            $table->string('MCODMON', 4)->nullable();
            $table->string('MDESCRIP', 41)->nullable();
            $table->string('MABREVI', 21)->nullable();
            $table->string('MCODPAI', 4)->nullable();
            $table->string('MSIMBOLO', 6)->nullable();
            $table->string('MDOLINT', 2)->nullable();
            $table->string('MCODTMS', 2)->nullable();
            $table->string('MCODUSER', 16)->nullable();
            $table->date('MFECUACT')->nullable();
            $table->string('MHORUACT', 11)->nullable();
            $table->string('MSNT_TDM', 4)->nullable();
            $table->string('MLCODMON', 41)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ccmmon');
    }
}
