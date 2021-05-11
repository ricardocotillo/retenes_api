<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCcmcpaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ccmcpa', function (Blueprint $table) {
            $table->integer('id')->primary('ccmcpa_pkey');
            $table->string('MCONDPAGO', 6)->nullable();
            $table->string('MDESCRIP', 41)->nullable();
            $table->string('MABREVI', 21)->nullable();
            $table->string('MINDCRED', 2)->nullable();
            $table->decimal('MNCUOTAS', 3, 0)->nullable();
            $table->decimal('MDIAS', 3, 0)->nullable();
            $table->string('MTIPCRE', 2)->nullable();
            $table->string('MMF', 2)->nullable();
            $table->string('MCAN_AUT', 2)->nullable();
            $table->string('MCODUSER', 16)->nullable();
            $table->date('MFECUACT')->nullable();
            $table->string('MHORUACT', 11)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ccmcpa');
    }
}
