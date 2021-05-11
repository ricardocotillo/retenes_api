<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticuloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulo', function (Blueprint $table) {
            $table->id();
            $table->string('MCODART', 20)->nullable();
            $table->string('MDESCRIP', 61)->nullable();
            $table->string('MABREVI', 21)->nullable();
            $table->string('MCODTPT', 3)->nullable();
            $table->string('MCODFAM', 5)->nullable();
            $table->string('MCODCLA', 7)->nullable();
            $table->string('MCODEQUI', 11)->nullable();
            $table->string('MUNIDAD', 6)->nullable();
            $table->string('MINDCTO', 2)->nullable();
            $table->string('MINDDEC', 2)->nullable();
            $table->string('MINDPRD', 2)->nullable();
            $table->string('MINDSPRD', 2)->nullable();
            $table->string('MINDCADU', 2)->nullable();
            $table->string('MINDSERIE', 2)->nullable();
            $table->string('MINDLOTE', 2)->nullable();
            $table->string('MCTAARANC', 16)->nullable();
            $table->date('MFECULSA')->nullable();
            $table->date('MFECULIN')->nullable();
            $table->date('MFECULCO')->nullable();
            $table->date('MFECUVEN')->nullable();
            $table->decimal('MPENDING', 14, 3)->nullable();
            $table->decimal('MPENDSAL', 14, 3)->nullable();
            $table->string('MCODACA', 3)->nullable();
            $table->string('MCODLAD', 3)->nullable();
            $table->string('MCODNOR', 3)->nullable();
            $table->string('MCODFOR', 3)->nullable();
            $table->string('MCOMI', 2)->nullable();
            $table->string('MINSUMO', 2)->nullable();
            $table->decimal('MPESO', 12, 4)->nullable();
            $table->decimal('MFACRUM', 8, 4)->nullable();
            $table->string('MESTADO', 2)->nullable();
            $table->decimal('MSTOCKINI', 14, 3)->nullable();
            $table->string('MGRUPO', 3)->nullable();
            $table->decimal('MCOSTOINI', 14)->nullable();
            $table->decimal('MCOSTO', 14)->nullable();
            $table->decimal('MCOSULCO', 14)->nullable();
            $table->string('MCODALT', 3)->nullable();
            $table->string('MCODCOL', 3)->nullable();
            $table->decimal('MSTOCK', 14, 3)->nullable();
            $table->decimal('MSTOCKSAL', 14, 3)->nullable();
            $table->decimal('MSTOCKENT', 14, 3)->nullable();
            $table->string('MCTAVEN', 16)->nullable();
            $table->string('MCTADCTO', 16)->nullable();
            $table->decimal('MSTOCKMIN', 14, 3)->nullable();
            $table->decimal('MSTOCKMAX', 14, 3)->nullable();
            $table->decimal('MSTCOMPR', 14, 3)->nullable();
            $table->decimal('MPVENTA', 14, 4)->nullable();
            $table->string('MPROCEDE', 2)->nullable();
            $table->string('MCTACTB', 16)->nullable();
            $table->decimal('MFACUTIL', 6, 3)->nullable();
            $table->decimal('MFACUT1', 6, 3)->nullable();
            $table->decimal('MFACUTSG', 6, 3)->nullable();
            $table->date('MFECREGI')->nullable();
            $table->string('MMDAULCO', 4)->nullable();
            $table->decimal('MVALREPOS', 14)->nullable();
            $table->string('MLINSER', 2)->nullable();
            $table->decimal('MPORDCTO', 6, 3)->nullable();
            $table->string('MOFERTA', 2)->nullable();
            $table->date('MFCHVALOF')->nullable();
            $table->decimal('MPVENTA1', 14, 4)->nullable();
            $table->decimal('MPVTAS01', 14, 4)->nullable();
            $table->decimal('MPVTAS02', 14, 4)->nullable();
            $table->decimal('MPVTAS03', 14, 4)->nullable();
            $table->decimal('MPVTAS04', 14, 4)->nullable();
            $table->decimal('MPVTAS05', 14, 4)->nullable();
            $table->decimal('MFACUT01', 6, 3)->nullable();
            $table->decimal('MFACUT02', 6, 3)->nullable();
            $table->decimal('MFACUT03', 6, 3)->nullable();
            $table->decimal('MTIEMPO', 5)->nullable();
            $table->string('MCODFMP', 3)->nullable();
            $table->string('MCODPST', 3)->nullable();
            $table->string('MCODBOC', 3)->nullable();
            $table->string('MCAVI', 3)->nullable();
            $table->string('MCODPRO', 16)->nullable();
            $table->string('MCODCLI', 16)->nullable();
            $table->decimal('MTIEACA', 5)->nullable();
            $table->string('MCODANT', 9)->nullable();
            $table->string('MOBSERV', 61)->nullable();
            $table->string('MCODGNR', 5)->nullable();
            $table->string('MCODCLD', 5)->nullable();
            $table->string('MCODTEN', 5)->nullable();
            $table->string('MCODDESP', 11)->nullable();
            $table->string('MCODUMED', 3)->nullable();
            $table->decimal('MPNETO', 14, 6)->nullable();
            $table->decimal('MPBRUTO', 14, 6)->nullable();
            $table->string('MCODUSER', 16)->nullable();
            $table->date('MFECUACT')->nullable();
            $table->string('MHORUACT', 11)->nullable();
            $table->decimal('MPVTAS06', 14, 4)->nullable();
            $table->decimal('MPVTAS07', 14, 4)->nullable();
            $table->decimal('MPVTAS08', 14, 4)->nullable();
            $table->decimal('MPVTAS09', 14, 4)->nullable();
            $table->decimal('MPVTAS10', 14, 4)->nullable();
            $table->decimal('MPVTAS11', 14, 4)->nullable();
            $table->decimal('MPVTAS12', 14, 4)->nullable();
            $table->decimal('MPVTAS13', 14, 4)->nullable();
            $table->decimal('MPVTAS14', 14, 4)->nullable();
            $table->decimal('MPVTAS15', 14, 4)->nullable();
            $table->decimal('MPVTAS16', 14, 4)->nullable();
            $table->decimal('MPVTAS17', 14, 4)->nullable();
            $table->decimal('MPVTAS18', 14, 4)->nullable();
            $table->decimal('MPVTAS19', 14, 4)->nullable();
            $table->decimal('MPVTAS20', 14, 4)->nullable();
            $table->string('MAFE_IGV', 2)->nullable();
            $table->decimal('MPOR_ISC', 6, 3)->nullable();
            $table->decimal('MPOR_COMI', 8, 5)->nullable();
            $table->string('MIND_ENS', 2)->nullable();
            $table->decimal('MROTA_EST', 14, 3)->nullable();
            $table->decimal('MDIM_INT1', 6, 3)->nullable();
            $table->decimal('MDIM_EXT1', 6, 3)->nullable();
            $table->decimal('MDIM_ALT1', 6, 3)->nullable();
            $table->decimal('MDIM_INT2', 6, 3)->nullable();
            $table->decimal('MDIM_INT3', 6, 3)->nullable();
            $table->decimal('MDIM_EXT2', 6, 3)->nullable();
            $table->decimal('MDIM_EXT3', 6, 3)->nullable();
            $table->decimal('MDIM_ALT2', 6, 3)->nullable();
            $table->decimal('MDIM_ALT3', 6, 3)->nullable();
            $table->string('MNRO_FAB', 11)->nullable();
            $table->string('MGI_STRIA', 6)->nullable();
            $table->string('MINDPROMO', 2)->nullable();
            $table->string('MCOD_ORI', 16)->nullable();
            $table->string('MDISENO', 16)->nullable();
            $table->decimal('MPLNCH_ESP', 8, 3)->nullable();
            $table->decimal('MPLNCH_CAN', 8, 3)->nullable();
            $table->decimal('MPASOSMTRZ', 8, 3)->nullable();
            $table->decimal('MCASCO_PES', 8, 3)->nullable();
            $table->decimal('MCASCO_ESP', 8, 3)->nullable();
            $table->decimal('MTAPA_PES', 8, 3)->nullable();
            $table->decimal('MTAPA_ESP', 8, 3)->nullable();
            $table->decimal('MRESOR_PES', 8, 3)->nullable();
            $table->decimal('MRESOR_ESP', 8, 3)->nullable();
            $table->decimal('MRESOR_LON', 8, 3)->nullable();
            $table->decimal('MRESOR_DIA', 8, 3)->nullable();
            $table->decimal('MCAUCHCR_W', 8, 3)->nullable();
            $table->decimal('MCAUCHSR_W', 8, 3)->nullable();
            $table->string('MN_CORECTI', 11)->nullable();
            $table->date('MF_CORECTI')->nullable();
            $table->string('MNRO_MEMO', 11)->nullable();
            $table->date('MFCH_MEMO')->nullable();
            $table->string('MNOMB_PLIS', 51)->nullable();
            $table->string('MENVASE1', 6)->nullable();
            $table->decimal('MUNDENV1', 14, 6)->nullable();
            $table->string('MENVASE2', 6)->nullable();
            $table->decimal('MUNDENV2', 14, 6)->nullable();
            $table->date('MFECCADU')->nullable();
            $table->decimal('MPNETESC', 14, 6)->nullable();
            $table->decimal('MNIVEXPM', 5, 0)->nullable();
            $table->string('MBOLIND', 2)->nullable();
            $table->string('MBOLDES', 21)->nullable();
            $table->string('MBOLUME', 6)->nullable();
            $table->decimal('MBOLPESO', 14)->nullable();
            $table->decimal('MBOLFCB', 14, 6)->nullable();
            $table->string('MCODUME1', 3)->nullable();
            $table->string('MCODUME2', 3)->nullable();
            $table->string('MCODUME3', 3)->nullable();
            $table->string('MENVASE3', 6)->nullable();
            $table->decimal('MUNDENV3', 14, 6)->nullable();
            $table->string('MCODUME4', 3)->nullable();
            $table->string('MENVASE4', 6)->nullable();
            $table->decimal('MUNDENV4', 14, 6)->nullable();
            $table->string('MINDOBSQ', 2)->nullable();
            $table->string('MCODTIES', 6)->nullable();
            $table->string('MRTACION', 11)->nullable();
            $table->string('MAFEPERC', 2)->nullable();
            $table->string('MCODSCLA', 7)->nullable();
            $table->string('MCODVAR01', 7)->nullable();
            $table->string('MCODVAR02', 7)->nullable();
            $table->string('MDES_ADI', 11)->nullable();
            $table->string('MCODDCTOP', 6)->nullable();
            $table->string('MCODDCTOE', 6)->nullable();
            $table->char('mdisc_dia', 10)->nullable();
            $table->char('ind_vend', 5)->nullable();
            $table->decimal('mcantmin', 14, 3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulo');
    }
}
