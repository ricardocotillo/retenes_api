<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCcmvenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ccmven', function (Blueprint $table) {
            $table->integer('id')->primary('ccmven_pkey');
            $table->string('MCODVEN', 6)->nullable();
            $table->string('MNOMBRE', 41)->nullable();
            $table->string('MDIRECC', 41)->nullable();
            $table->string('MDOCIDEN', 16)->nullable();
            $table->decimal('MPORCEN', 4)->nullable();
            $table->string('MTIPVEN', 2)->nullable();
            $table->string('MCODGVE', 6)->nullable();
            $table->string('MCODJVE', 6)->nullable();
            $table->string('MFCACOMI', 2)->nullable();
            $table->string('MINDCOM', 2)->nullable();
            $table->string('MINDVEND', 2)->nullable();
            $table->string('MSITUAC', 2)->nullable();
            $table->string('MCODUSER', 16)->nullable();
            $table->date('MFECUACT')->nullable();
            $table->string('MHORUACT', 11)->nullable();
            $table->string('MCLAVE', 17)->nullable();
            $table->bigInteger('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ccmven');
    }
}
