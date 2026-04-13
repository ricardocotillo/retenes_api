<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function () {
            // Check for duplicate mcla_prod codes in tipo_de_descuentos
            $duplicates = DB::table('tipo_de_descuentos')
                ->select('mcla_prod', DB::raw('count(*) as count'))
                ->whereNotNull('mcla_prod')
                ->groupBy('mcla_prod')
                ->having('count', '>', 1)
                ->get();

            if ($duplicates->isNotEmpty()) {
                $codes = $duplicates->pluck('mcla_prod')->implode(', ');
                throw new \Exception("Ambiguous backfill: Duplicate mcla_prod codes found in tipo_de_descuentos ({$codes})");
            }

            // Check if any articulo_famdfa.mcla_prod is missing in tipo_de_descuentos
            $missing = DB::table('articulo_famdfa')
                ->select('mcla_prod')
                ->whereNotNull('mcla_prod')
                ->where('mcla_prod', '!=', '')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('tipo_de_descuentos')
                        ->whereRaw('tipo_de_descuentos.mcla_prod = articulo_famdfa.mcla_prod');
                })
                ->distinct()
                ->get();

            if ($missing->isNotEmpty()) {
                $codes = $missing->pluck('mcla_prod')->implode(', ');
                throw new \Exception("Incomplete backfill: Missing mcla_prod codes in tipo_de_descuentos ({$codes})");
            }

            // Backfill from articulo_famdfa to the pivot table
            DB::statement("
                INSERT INTO articulo_famdfa_tipo_de_descuento (articulo_famdfa_id, tipo_de_descuento_id, created_at, updated_at)
                SELECT af.id, td.id, NOW(), NOW()
                FROM articulo_famdfa af
                JOIN tipo_de_descuentos td ON af.mcla_prod = td.mcla_prod
                WHERE af.mcla_prod IS NOT NULL AND af.mcla_prod != ''
            ");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('articulo_famdfa_tipo_de_descuento')->truncate();
    }
};
