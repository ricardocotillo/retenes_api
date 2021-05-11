<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCcmdocTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ccmdoc', function (Blueprint $table) {
            $table->id();
            $table->string('MTIPODOC', 3)->nullable();
            $table->string('MDESCRIP', 41)->nullable();
            $table->string('MABREVI', 21)->nullable();
            $table->string('MIND_S_R', 2)->nullable();
            $table->string('MINDDOC', 2)->nullable();
            $table->string('MDESTINO', 41)->nullable();
            $table->string('MCODSUNAT', 3)->nullable();
            $table->string('MINDAPRO', 2)->nullable();
            $table->string('MCODSID', 3)->nullable();
            $table->string('MCODSPA', 3)->nullable();
            $table->string('MCODUSER', 16)->nullable();
            $table->date('MFECUACT')->nullable();
            $table->string('MHORUACT', 11)->nullable();
            $table->decimal('MNCOPIAS', 2, 0)->nullable();
            $table->char('mregvta', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ccmdoc');
    }
}
