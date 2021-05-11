<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCabpeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cabpe', function (Blueprint $table) {
            $table->id();
            $table->string('MTIPODOC', 3)->nullable();
            $table->string('MNSERIE', 4)->nullable();
            $table->string('MNROPED', 7)->nullable();
            $table->string('MCODTPED', 3)->nullable();
            $table->date('MFECEMI')->nullable();
            $table->string('MPERIODO', 7)->nullable();
            $table->string('MCODCLI', 16)->nullable();
            $table->string('MCODCPA', 6)->nullable();
            $table->string('MCODVEN', 6)->nullable();
            $table->string('MCODZON', 5)->nullable();
            $table->string('MCODTIEN', 6)->nullable();
            $table->string('MCODMON', 4)->nullable();
            $table->string('MDOLINT', 2)->nullable();
            $table->date('MFECENT')->nullable();
            $table->string('MLUGENT', 250)->nullable();
            $table->string('MLOCALID', 41)->nullable();
            $table->string('MDETALLE', 41)->nullable();
            $table->string('MCODEMI', 4)->nullable();
            $table->string('MEMITIDO', 41)->nullable();
            $table->decimal('MTOPVENTA', 14)->nullable();
            $table->decimal('MVALVEN', 14)->nullable();
            $table->decimal('MDCTO', 14)->nullable();
            $table->decimal('MIGV', 14)->nullable();
            $table->decimal('MNETO', 14)->nullable();
            $table->decimal('MSALDO', 14)->nullable();
            $table->decimal('MPORIGV', 5)->nullable();
            $table->date('MFECVEN')->nullable();
            $table->date('MFECCAN')->nullable();
            $table->string('MCODCRES', 9)->nullable();
            $table->string('MSTATUS', 2)->nullable();
            $table->string('MINDORIG', 2)->nullable();
            $table->string('MIND_N_I', 2)->nullable();
            $table->string('MINDAPROB', 2)->nullable();
            $table->string('MINDIMP', 2)->nullable();
            $table->string('MTIPITEM', 2)->nullable();
            $table->string('MINC_IGV', 2)->nullable();
            $table->string('MANO_E', 5)->nullable();
            $table->string('MMES_E', 3)->nullable();
            $table->string('MDIA_E', 3)->nullable();
            $table->date('MFECATT')->nullable();
            $table->date('MFECANU')->nullable();
            $table->string('MATEND', 2)->nullable();
            $table->string('MNORDCLI', 16)->nullable();
            $table->string('MAMD', 9)->nullable();
            $table->string('MINDFACT', 2)->nullable();
            $table->string('MCODLPRE', 3)->nullable();
            $table->string('MNOMCLI', 250)->nullable();
            $table->string('MLUGFAC', 250)->nullable();
            $table->date('MFECLIB')->nullable();
            $table->string('MCODSITD', 3)->nullable();
            $table->date('MFECUACT')->nullable();
            $table->string('MCODUSER', 16)->nullable();
            $table->string('MHORUACT', 9)->nullable();
            $table->string('MOBSERV', 41)->nullable();
            $table->string('MINDCOM', 2)->nullable();
            $table->string('MOBRA', 6)->nullable();
            $table->decimal('MPESOKG', 14)->nullable();
            $table->string('MCODDFA', 6)->nullable();
            $table->string('MDPSUNAT', 2)->nullable();
            $table->string('MDOCCLTE', 16)->nullable();
            $table->string('MCODRUV', 7)->nullable();
            $table->decimal('MVV_NAFE', 14)->nullable();
            $table->string('MCODCADI', 3)->nullable();
            $table->string('MCODSCADI', 5)->nullable();
            $table->string('MCTOUTIL', 9)->nullable();
            $table->string('MLIMAPROV', 2)->nullable();
            $table->string('estado', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cabpe');
    }
}
