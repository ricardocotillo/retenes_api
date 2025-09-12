<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        Schema::table('detpe_famdfa', function (Blueprint $table) {
            $table->integer('order')->storedAs(DB::raw("CASE WHEN type = 'item' THEN 1 WHEN type = 'retenes' AND mcla_prod IS NOT NULL THEN 2 WHEN type = 'retenes' AND mcla_prod IS NULL THEN 3 ELSE 4 END"));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detpe_famdfa', function (Blueprint $table) {
            //
        });
    }
};
