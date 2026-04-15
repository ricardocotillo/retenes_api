<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('articulo_famdfa', function (Blueprint $table) {
            // Composite index for the main filters in descuento_general
            $table->index(['tipo', 'mindcred', 'impneto_min'], 'af_tipo_mindcred_impneto_idx');

            // Individual indexes for the other filters
            $table->index('MCODCADI', 'af_mcodcadi_idx');
            $table->index('MCONDPAGO', 'af_mcondpago_idx');
            $table->index('MCODZON', 'af_mcodzon_idx');
            $table->index('MCODVEN', 'af_mcodven_idx');
            $table->index('MCODCLI', 'af_mcodcli_idx');
            $table->index('restrict', 'af_restrict_idx');

            // For index() method which filters by mcodart and null impneto
            $table->index(['mcodart', 'impneto_min', 'impneto_max'], 'af_mcodart_impneto_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('articulo_famdfa', function (Blueprint $table) {
            $table->dropIndex('af_tipo_mindcred_impneto_idx');
            $table->dropIndex('af_mcodcadi_idx');
            $table->dropIndex('af_mcondpago_idx');
            $table->dropIndex('af_mcodzon_idx');
            $table->dropIndex('af_mcodven_idx');
            $table->dropIndex('af_mcodcli_idx');
            $table->dropIndex('af_restrict_idx');
            $table->dropIndex('af_mcodart_impneto_idx');
        });
    }
};
