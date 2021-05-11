<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCcmcliTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ccmcli', function (Blueprint $table) {
            $table->id();
            $table->string('MCODCLI', 16)->nullable();
            $table->string('MNOMBRE', 250)->nullable();
            $table->string('MABREVI', 21)->nullable();
            $table->string('MDIRECC', 250)->nullable();
            $table->string('MLOCALID', 41)->nullable();
            $table->string('MCODPAI', 5)->nullable();
            $table->string('MCASPOS', 11)->nullable();
            $table->string('MUBIGEO', 9)->nullable();
            $table->string('MTELEF1', 16)->nullable();
            $table->string('MTELEF2', 16)->nullable();
            $table->string('MTELEX', 16)->nullable();
            $table->string('MFAX', 16)->nullable();
            $table->string('MPERSONA', 41)->nullable();
            $table->string('MCARGO', 31)->nullable();
            $table->string('MCODVEN', 6)->nullable();
            $table->string('MRUCCLTE', 16)->nullable();
            $table->string('MDOCIDEN', 11)->nullable();
            $table->string('MCODZON', 5)->nullable();
            $table->string('MCODRCLI', 3)->nullable();
            $table->date('MFCHREGIS')->nullable();
            $table->string('MDIRDESP', 81)->nullable();
            $table->string('MINDCRED', 2)->nullable();
            $table->string('MMNDA_CR', 4)->nullable();
            $table->decimal('MVCAM_CR', 12, 3)->nullable();
            $table->decimal('MLIM_CR', 14)->nullable();
            $table->date('MFCH_CR')->nullable();
            $table->string('MIND_MOR', 2)->nullable();
            $table->string('MCONDPAGO', 6)->nullable();
            $table->string('MTIPOCLI', 3)->nullable();
            $table->string('MCTACTB', 16)->nullable();
            $table->string('MTIPANA', 5)->nullable();
            $table->string('MCTAANA', 16)->nullable();
            $table->string('MCALIFI', 3)->nullable();
            $table->date('MFECUVTA')->nullable();
            $table->date('MFECULCRE')->nullable();
            $table->decimal('MPORDCTO', 5)->nullable();
            $table->decimal('MPORCOMI', 15)->nullable();
            $table->string('MCODGRP', 5)->nullable();
            $table->string('MCORREO', 151)->nullable();
            $table->string('MINDVAR', 2)->nullable();
            $table->string('MOBSERV', 61)->nullable();
            $table->string('MCODLPRE', 3)->nullable();
            $table->string('MPATERNO', 21)->nullable();
            $table->string('MMATERNO', 21)->nullable();
            $table->string('MNOMBRE1', 21)->nullable();
            $table->string('MNOMBRE2', 21)->nullable();
            $table->string('MTPSUNAT', 3)->nullable();
            $table->string('MDPSUNAT', 2)->nullable();
            $table->string('MCODUSER', 16)->nullable();
            $table->date('MFECUACT')->nullable();
            $table->string('MHORUACT', 11)->nullable();
            $table->string('MINDCOM', 2)->nullable();
            $table->string('MCERUS', 21)->nullable();
            $table->string('MAREAPER', 41)->nullable();
            $table->string('MNOMAVAL', 61)->nullable();
            $table->string('MDIRAVAL', 71)->nullable();
            $table->string('MLOCAVAL', 41)->nullable();
            $table->string('MTELAVAL', 16)->nullable();
            $table->string('MDOIAVAL', 16)->nullable();
            $table->string('MAGEPERC', 2)->nullable();
            $table->string('MAGERETE', 2)->nullable();
            $table->string('MDIRREF', 51)->nullable();
            $table->string('MCODRUV', 7)->nullable();
            $table->string('MDIAVIS', 2)->nullable();
            $table->string('MORDVIS', 5)->nullable();
            $table->string('MINDACT', 2)->nullable();
            $table->string('MINDPERC', 2)->nullable();
            $table->decimal('MPORPERC', 5)->nullable();
            $table->date('MFECALTA')->nullable();
            $table->date('MFECBAJA')->nullable();
            $table->decimal('MPORVCAO', 6)->nullable();
            $table->decimal('MPORVNAOH', 6)->nullable();
            $table->string('MCODCADI', 3)->nullable();
            $table->string('MCODSCADI', 5)->nullable();
            $table->string('MOBSERVA01')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ccmcli');
    }
}
