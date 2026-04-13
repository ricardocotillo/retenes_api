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
        // 1. Count non-null/non-empty mcla_prod rows in articulo_famdfa
        $expectedCount = DB::table('articulo_famdfa')
            ->whereNotNull('mcla_prod')
            ->where('mcla_prod', '!=', '')
            ->count();

        // 2. Count pivot rows
        $actualCount = DB::table('articulo_famdfa_tipo_de_descuento')->count();

        if ($expectedCount !== $actualCount) {
            throw new \Exception("Data integrity check failed: Expected {$expectedCount} pivot rows, but found {$actualCount}.");
        }

        // 3. Verify each articulo_famdfa row has a pivot entry
        $missingPivotEntries = DB::table('articulo_famdfa')
            ->whereNotNull('mcla_prod')
            ->where('mcla_prod', '!=', '')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('articulo_famdfa_tipo_de_descuento')
                    ->whereRaw('articulo_famdfa_tipo_de_descuento.articulo_famdfa_id = articulo_famdfa.id');
            })
            ->count();

        if ($missingPivotEntries > 0) {
            throw new \Exception("Data integrity check failed: Found {$missingPivotEntries} rows in articulo_famdfa missing pivot entries.");
        }

        // 4. Check for duplicate (articulo_famdfa_id, tipo_de_descuento_id) pairs
        $duplicatePairs = DB::table('articulo_famdfa_tipo_de_descuento')
            ->select('articulo_famdfa_id', 'tipo_de_descuento_id', DB::raw('count(*) as count'))
            ->groupBy('articulo_famdfa_id', 'tipo_de_descuento_id')
            ->havingRaw('count(*) > 1')
            ->count();

        if ($duplicatePairs > 0) {
            throw new \Exception("Data integrity check failed: Found duplicate (articulo_famdfa_id, tipo_de_descuento_id) pairs in pivot table.");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Verification is non-destructive
    }
};
