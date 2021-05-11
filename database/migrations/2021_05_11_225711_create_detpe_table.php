<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetpeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detpe', function (Blueprint $table) {
            $table->id();
            $table->string('MTIPODOC', 3)->nullable();
            $table->string('MNSERIE', 4)->nullable();
            $table->string('MNROPED', 7)->nullable();
            $table->string('MITEM', 3)->nullable();
            $table->string('MCODART', 16)->nullable();
            $table->string('MTDOCR', 2)->nullable();
            $table->string('MNSERIER', 4)->nullable();
            $table->string('MNROREQ', 7)->nullable();
            $table->decimal('MCANTIDAD', 14, 3)->nullable();
            $table->decimal('MCANTPEN', 14, 3)->nullable();
            $table->string('MUNIDAD', 6)->nullable();
            $table->string('MCODUMED', 3)->nullable();
            $table->decimal('MFACTOR', 14, 6)->nullable();
            $table->string('MDESCRI01', 60)->nullable();
            $table->decimal('MIGV', 12)->nullable();
            $table->decimal('MPORDCT1', 6, 3)->nullable();
            $table->decimal('MPORDCT2', 6, 3)->nullable();
            $table->decimal('MDCTOPRD', 12)->nullable();
            $table->decimal('MDCTO', 14)->nullable();
            $table->decimal('MPRECIO', 14, 4)->nullable();
            $table->decimal('MVALVEN', 14)->nullable();
            $table->decimal('MCOSULCO', 14, 4)->nullable();
            $table->string('MCODSER', 9)->nullable();
            $table->string('MINDSER', 2)->nullable();
            $table->string('MSTATUS', 2)->nullable();
            $table->string('MINDORIG', 2)->nullable();
            $table->string('MAMD', 9)->nullable();
            $table->string('MAFE_IGV', 2)->nullable();
            $table->string('MOBSERV', 41)->nullable();
            $table->string('MINDOBSQ', 2)->nullable();
            $table->string('MITE_REL', 3)->nullable();
            $table->string('MART_REL', 11)->nullable();
            $table->string('MCODUSER', 16)->nullable();
            $table->date('MFECUACT')->nullable();
            $table->string('MHORUACT', 9)->nullable();
            $table->string('MINDCOM', 2)->nullable();
            $table->string('MCODDFA', 20)->nullable();
            $table->decimal('MPENFAC', 14, 3)->nullable();
            $table->string('MTDCTZ', 3)->nullable();
            $table->string('MNSCTZ', 4)->nullable();
            $table->string('MNROCTZ', 7)->nullable();
            $table->string('MITEMCTZ', 3)->nullable();
            $table->decimal('MCANUND', 14, 3)->nullable();
            $table->decimal('MPESOKG', 14)->nullable();
            $table->decimal('MPORDCT3', 6, 3)->nullable();
            $table->decimal('MPORDCT4', 6, 3)->nullable();
            $table->decimal('MPORDCT5', 6, 3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detpe');
    }
}
