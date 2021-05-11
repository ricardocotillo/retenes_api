<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamdfaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('famdfa', function (Blueprint $table) {
            $table->integer('id')->primary('famdfa_pkey');
            $table->string('MCODDFA', 6)->nullable();
            $table->string('MDESCRIP', 41)->nullable();
            $table->string('MABREVI', 16)->nullable();
            $table->string('MFOR_DFA', 2)->nullable();
            $table->decimal('MPOR_DFA', 7, 4)->nullable();
            $table->decimal('MIMP_DFA', 14)->nullable();
            $table->string('MDESACT', 2)->nullable();
            $table->date('MFECREG')->nullable();
            $table->string('MHORREG', 11)->nullable();
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
        Schema::dropIfExists('famdfa');
    }
}
